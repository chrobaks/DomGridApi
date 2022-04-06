<?php

/**
 * Class DataTableModel
 */
class DataTableModel extends BaseModel
{
    private object $config;
    private object $query;
    private bool $doResponse;
    private string $dbTable;

    public function __construct (String $dbTable, Array $config = [])
    {
        parent::__construct();

        $this->dbTable = $dbTable;
        $this->config = (object)[
            "start"     => 1,
            "end"       => 100,
            "next"      => 0,
            "step"      => 1,
            "stepLen"   => $config["stepLen"] ?? 3,
            "maxStep"   => 0,
            "maxLen"    => 450,
            "actualLen" => 0,
            "rowLen"    => 100
        ];
        $this->query = (object)[
            "dataLength" => "",
            "data" => "",
            "whereParam" => [],
            "orderBy" => "",
        ];
        $this->doResponse = true;
    }

    /**
     * Method getData
     * @return array
     * ------------------------
     * Create and return assoc array from db table results
     */
    public function getData ($queryId = ""): array
    {
        // Store dataTable config and results
        $dataTable = [];

        if (!$this->checkConfigQueryId($queryId)) {
            return $dataTable;
        }

        // Create DB Query
        $this->setDataTableQuery($queryId);

        // Set actual config
        $this->setConfig();
        if ($this->doResponse){ // If config allows response

            $query = ($this->config->start < 2)
                ? $this->query->data." LIMIT ".$this->config->stepLen
                : $this->query->data." LIMIT ".$this->config->start.", ".$this->config->stepLen;

            $dbData = $this->getQuery($query, "", $this->query->whereParam);
            $setHeader = !(isset($_REQUEST['step']) || isset($_REQUEST['contlen']));
            $dataTable = get_object_vars($this->config);
            $dbDataArr = ["content" => []];
            $columns_alias = AppConfig::getConfig('mysql', ["column_alias", $this->dbTable]);

            if ($setHeader) { 
                $dbDataArr["header"] = $columns_alias ?? array_keys($dbData[0]);
            }

            foreach($dbData as $data) { $dbDataArr["content"][] = array_values($data); }

            // Merge config and data results
            $dataTable = array_merge($dataTable, $dbDataArr);
        }

        return $dataTable;
    }

    private function checkConfigQueryId (String $queryId): bool
    {
        return !!(empty($queryId) || AppConfig::getConfig('mysql', ['query', $queryId]));
    }

    /**
     * Method setDataTableQuery
     * @return void
     * ------------------------
     * Create MySql query for results length and results from Db table
     */
    private function setDataTableQuery ($config = ""): void
    {
        // Store Where statement
        $where = "";

        // Create Where Statement if search param exists
        if (isset($_REQUEST['val'])
            && isset($_REQUEST['type'])
            && isset($_REQUEST['column'])) {
            $where = " WHERE " . $_REQUEST['column'] . "= ? ";
        }
        // Create data length statement
        $this->query->dataLength = "SELECT count(*) as dataCount FROM ".$this->dbTable.$where;

        // Create data statement
        $this->query->data = (empty($config))
            ? "SELECT * FROM ".$this->dbTable.$where
            : AppConfig::getConfig('mysql', ['query', $config]).$where;

        if ($orderBy = AppConfig::getConfig('mysql', ['orderBy', $this->dbTable])) {
            $this->query->data .= " Order BY ".$orderBy;
        }

        // Set where param if where statement exists
        $this->query->whereParam = (empty($where)) ? [] : [$_REQUEST['val']];
    }

    /**
     * Method setConfig
     * @return void
     * ------------------------
     * Build datatable config
     */
    private function setConfig (): void
    {
        // Get data results count
        $dbDataLength = $this->getQuery($this->query->dataLength, "", $this->query->whereParam, true);

        // Check data is empty (dataCount=0)
        if ((int) $dbDataLength["dataCount"] < 1) {
            $this->doResponse = false;
        } else {
            $this->config->maxLen = $dbDataLength["dataCount"];
            $this->config->stepLen = $_REQUEST['contlen'] ?? $this->config->stepLen;
            $this->config->actualLen = $this->config->stepLen;
            $this->config->maxStep = ceil($this->config->maxLen / $this->config->stepLen);
            $this->config->end = $this->config->stepLen * $this->config->step;

            if (isset($_REQUEST['step'])) {
                $this->config->step = $_REQUEST['step'];
                $this->config->next = $this->config->stepLen * $this->config->step;
                $this->config->start = ($this->config->step < 2) ? 1 : $this->config->next - $this->config->stepLen;
                $this->config->end = ($this->config->maxLen < $this->config->next) ? $this->config->maxLen : $this->config->next;
                $this->config->actualLen = $this->config->end;
                $this->config->rowLen = $this->config->end - $this->config->start;
                if ($this->config->maxLen < $this->config->start || (int)$this->config->step < 1) {
                    $this->doResponse = false;
                }
            } else if (isset($_REQUEST['contlen'])) {
                $this->config->stepLen = $_REQUEST['contlen'];
                $this->config->next = $this->config->stepLen * $this->config->step;
                $this->config->end = ($this->config->maxLen < $this->config->next) ? $this->config->maxLen : $this->config->next;
                $this->config->actualLen = ($this->config->maxLen < $this->config->next + $this->config->stepLen) ? $this->config->maxLen : $this->config->next;
                $this->config->rowLen = $this->config->end - $this->config->start;
            }
        }
    }
}
