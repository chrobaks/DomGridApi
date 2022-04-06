<?php
/**
 * Model Class BaseModel
 * -----------------------------------------------------------
 * 
 * class BaseModel
 * 
 * @extends PDOHandler
 */

class BaseModel extends PDOHandler
 {
    protected int $modelId;
    protected PDOHandler $modelDB;
    protected array $mysqlConfig;
    protected array $modelInfo;
    protected array $modelError;
    protected array $truncateIgnore;
    public string $tableName;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct ($tableName = "") {
        $this->modelDB = parent::get_instance();
        $this->mysqlConfig = AppConfig::getConfig('mysql');
        $this->tableName = $tableName;
        $this->modelInfo = [];
        $this->modelError = [];
        $this->truncateIgnore = [];
        $this->modelId = 0;

    }

    public function validate (String $validateId): bool
    {
        $result = false;
        AppValidator::setValidation($validateId, $_POST);
        if(AppValidator::isValid()) {
            $_POST = AppValidator::getResult();
            $result = true;
        }
        return $result;
    }

    public function setModelId ($id = null): bool
    {
        if ($id !== null && preg_match("/^[\d]{1,11}$/", $id)) {
            $this->modelId = $id;
            return true;
        }

        $urlList = AppRoute::getUrlList();

        if (count($urlList) > 2 && $urlList[2] !== '' && preg_match("/^[\d]{1,11}$/", $urlList[2])) {
            $this->modelId = $urlList[2];
            return true;
        }

        return false;
    }

    public function setError ($error): void
    {
        if (is_array($error)) {
            $this->modelError = array_merge($this->modelError,  $error);
        } else {
            $this->modelError[] = $error;
        }
    }

    public function setInfo ($info): void
    {
        $this->modelInfo[] = $info;
    }

    public function setSearch (String $sql, String $strSearch): array
    {
        if (!isset($this->mysqlConfig["query"][$sql])) {
            return [];
        }

        return $this->getQuery(vsprintf($this->mysqlConfig["query"][$sql], ['%'.$strSearch.'%']));
    }

    public function setDelete ($dependency = []): bool
    {
        $query = str_replace('%table%', $this->tableName, $this->mysqlConfig['query']['delete']);
        $result = $this->setQuery($query, [$_POST["id"]]);

        if (!empty($dependency) && $result) {
            $query = str_replace(['%table%', '%column%'], [$dependency["tbl"], $dependency["column"]], $this->mysqlConfig['query']['deleteDependency']);
            $this->setQuery($query, [$_POST["id"]]);
        }

        return $result;
    }

    /**
     * setQuery
     *
     * @param  string $sql
     * @param  array $bindParam
     *
     * @return bool
     */
    public function setQuery (String $sql, Array $bindParam=[]): bool
    {
        $executeOk = false;
        $query = (isset($this->mysqlConfig['query'][$sql])) ? $this->mysqlConfig['query'][$sql] : $sql;

        try {

            $stat = $this->modelDB->DB->prepare($query);

            if (!empty($bindParam)) {
                $stat->execute($bindParam);
            } else {
                $stat->execute();
            }

            $executeOk = ((int) $stat->rowCount() > 0);

        } catch(exception $e) {
            $this->modelError[] = $e->getMessage();
        }

        return $executeOk;
    }

    public function setUpdate (String $tbl, Array $values, Int $objId = 0): bool
    {
        $setQuery = [];
        $id = $objId;
        $updateOk = false;

        foreach($values as $key => $val) {
            if ($key === 'id') {
                $id = $val;
            } else {
                $setQuery[] = $key.'=  "'.$val.'" ';
            }
        }

        if (!empty($setQuery)) {
            try {
                $query = "UPDATE $tbl SET ".implode(', ', $setQuery)." WHERE id = $id";
                $stat = $this->modelDB->DB->prepare($query);
                $stat->execute();
                $updateOk = true;
            } catch(exception $e) {
                $this->modelError[] = $e->getMessage();
                $updateOk = false;
            }
        }

        return $updateOk;
    }

    public function setInsert (String $tbl, $values, $isBlockAct = false, $prefix = ''): int
    {

        $lastInsertId = 0;
        $tblName = (!$prefix) ? $tbl : $prefix.$tbl;

        if (!isset($this->mysqlConfig['tables'][$tbl]) ) {
            return $lastInsertId;
        }

        try {

            $cols = (is_array($values)) ? "(".implode(",", array_keys($values)).")" : "(".implode(",",$this->mysqlConfig['tables'][$tbl]).")";

            if (!$isBlockAct) {
                $values = "('".implode("','",array_values($values))."')";
                $query = vsprintf("INSERT INTO $tblName %s VALUES %s", [$cols, $values]);
            } else {
                $query = "INSERT INTO $tblName $cols VALUES $values";
            }
            $stat = $this->modelDB->DB->prepare($query);

            try {
                $this->modelDB->DB->beginTransaction();
                $stat->execute();

                $lastInsertId = $this->modelDB->DB->lastInsertId();
                $this->modelDB->DB->commit();

            } catch(exception $e) {
                $this->modelDB->DB->rollback();
                $this->modelError[] = $e->getMessage();
                $lastInsertId = 0;
            }
        } catch(exception $e) {
            $this->modelError[] = $e->getMessage();
            $lastInsertId = 0;
        }

        return $lastInsertId;
    }

    public function setDropTable ($arrTblName)
    {
        if (!empty($arrTblName)) {
            foreach ($arrTblName as $tblName) {
                if ($this->checkTableExists($tblName)) { $this->setQuery("DROP TABLE ".$tblName); }
            }
        }
    }

    public function getError ($toString = false): array|string
    {
        $result = ($toString && !empty($this->modelError))
            ? implode("<br>", $this->modelError)
            : $this->modelError;

        return (empty($result) && $toString) ? "" : $result;
    }

    public function getInfo ($toString = false): array|string
    {
        $result = ($toString && !empty($this->modelInfo))
            ? "<br>".implode("<br>", $this->modelInfo)
            : $this->modelInfo;

        return (empty($result) && $toString) ? "" : $result;
    }

    public function getModelId (): int|string
    {
        return $this->modelId;
    }

    protected function setData (): bool
    {
        $action = ((int) $_POST['id'] === 0) ? "insert" : "update";
        $this->modelError = [];
        $result = true;
        if ($action === "insert") {
            $this->modelId = $this->setInsert($this->tableName, $_POST);
            // Return false if insert went wrong
            if ($this->modelId === 0) {
                $result = false;
                $this->setError('Add data false');
            }
        } else {
            $result = $this->setUpdate($this->tableName, $this->getPostUpdate($this->tableName));
        }

        return $result;
    }

    /**
     * getConfigQuery
     *
     * @param  string $sql
     * @param  array $queryId
     *
     * @return string
     */
    private function getConfigQuery ($sql, $queryId)
    {
        $result = '';

        if (isset($this->mysqlConfig[$sql][$queryId])) {
            $result = $this->mysqlConfig[$sql][$queryId];
        } elseif (!empty($sql) && empty($queryId)) {
            $result = $sql;
        }

        return $result;
    }

    public function getTblColNames ($tbl, $noId = false, $prefix = '')
    {
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '$tbl';";
        $queryRes = $this->getQuery($query);
        $result = [];
        foreach ($queryRes as $k=> $v) { 
            if (!$noId || $noId && $v['COLUMN_NAME'] !== 'id')
            $result[] = $prefix.$v['COLUMN_NAME']; 
        }

        return $result;
    }

    /**
     * getQuery
     *
     * @param  string $query
     * @param  array $bindParam
     *
     * @return array
     */
    public function getQuery ($sql, $queryId = '', Array $bindParam=[], Bool $onlyOne = false) 
    {
        $results = [];
        $query = $this->getConfigQuery ($sql, $queryId);

        if (empty($query)) {
            return $results;
        }

        try {

            $stat = $this->modelDB->DB->prepare($query);
            
            if (!empty($bindParam)) {
                $stat->execute($bindParam);
            } else {
                $stat->execute();
                
            }
            if ( (int) $stat->rowCount() > 0) {
                while($row = $stat->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $row;
                }
                if ($onlyOne ) {
                    $results = $results[0];
                }
            } 
        } catch(exception $e) {
            $this->modelError[] = $e->getMessage();
        } 
        // $stat->debugDumpParams();
        
        return $results;
    }

    public function createTbl ($tblName, $cols)
    {
        $this->setQuery("CREATE TABLE ".$tblName." (".implode(',',$cols).")");

        if ( ! $this->checkTableExists($tblName)) {
            $this->modelError[] = "Folgende Tabelle konnten nicht angelegt werden: ".$tblName;
            return false;
        }

        return true;
    }

    public function checkTableExists ($tbl)
    {
        $result = false;
        $queryRes = $this->getQuery('select', 'showTables');

        if (!empty($queryRes)) {
            foreach (array_values($queryRes) as $arr) {
                if (in_array($tbl, array_values($arr))) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    public function findOne ($tbl , $col, $val)
    {
        $result = [];
        try {
            
            $query = "SELECT * FROM $tbl WHERE $col = ? LIMIT 1";

            $stat = $this->modelDB->DB->prepare("SELECT * FROM $tbl WHERE $col = ? LIMIT 1");
            $stat->execute($val);
            $stat->execute();

            if ( (int) $stat->rowCount() > 0) {
                while($row = $stat->fetch(PDO::FETCH_ASSOC)) {
                    $result[] = $row;
                }
                $result = $result[0];
            }
        } catch (exception $e) {
            $this->modelError[] = $e->getMessage();
        }
        
        return $result;
    }

    public function getBlockValue ($tbl, $values): string
    {
        $tblConf = $this->mysqlConfig['tables'][$tbl] ?? [];
        $result = [];
        if (!empty($tblConf)) {
            foreach ($tblConf as $conf) {
                $result[] = $values[$conf];
            }
        }

        return implode(',', $result);

    }

    public function getPostModel (String $tbl, $options= [])
    {
        $result = $options;
        
        if (isset($this->mysqlConfig['tables'][$tbl])) {

            foreach($this->mysqlConfig['tables'][$tbl] as $key) {
                if (isset($_POST[$key])) {
                    if (isset($this->mysqlConfig['replace']['db'][$key])) {
                        $_POST[$key] = str_replace($this->mysqlConfig['replace']['db'][$key][0], $this->mysqlConfig['replace']['db'][$key][1], $_POST[$key]);
                    }
                    $result[$key] = $_POST[$key];
                }
            }
        }

        return $result;
    }

    public function getColModel (String $tbl, $item, $options= [])
    {
        $result = $options;
        
        if (isset($this->mysqlConfig['tables'][$tbl])) {

            foreach($item as $key => $val) {
                
                if (in_array($key, $this->mysqlConfig['tables'][$tbl])) {
                    
                    $result[$key] = $val;
                }
            }
        }
        
        return $result;
    }

    public function getUpdateData ($tbl, $newData, $dbData)
    {
        $result = [];

        if (!empty($dbData)) {

            foreach($dbData as $key => $val) {
                if ($key !== 'id' && isset($newData[$key]) && $newData[$key] !== $val) {
                    $result[$key] = $newData[$key];
                }
            }
            if (!empty($result)) {
                $result['id'] = $dbData['id'];
            }
        }

        return $result;
    }

    public function getPostUpdate ($tbl)
    {
        $item = $this->findOne($tbl, "id", [$_POST['id']]);
        $dbData = [];

        if (!empty($item)) {

            foreach($item as $key => $val) {
                if ($key !== 'id' && isset($_POST[$key]) && $_POST[$key] !== $val) {
                    $dbData[$key] = $_POST[$key];
                }
            }
            if (!empty($dbData)) {
                $dbData['id'] = $_POST['id'];
            }
        }

        return $dbData;
    }

    public function getTblCharCol ($maxCol)
    {
        $columnNames = range('a',"z");
        $result = [];
        $prefix = '';
        $counter = 0;
        $charCounter = 0;
        $postixCounter = 0;

        while ($counter < $maxCol) {
            if ($charCounter < count($columnNames)) {
                $result[] = $prefix.$columnNames[$charCounter];
                $charCounter ++;
            } else {
                $charCounter = 0;
                $prefix .= $columnNames[$postixCounter];
                $result[] = $prefix.$columnNames[$charCounter];
                $postixCounter ++;
                $charCounter ++;
            }
            $counter ++;
        }

        return $result;
    }

    public function isUpdate ()
    {
        return (in_array('id', array_keys($_POST))) ? true : false;
    }
 }
 
