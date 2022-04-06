<?php

class CustomPackageModel extends BaseModel
{
    public Array $error;
    private Int $id;

    public function __construct ($tableName = "")
    {
        parent::__construct($tableName);
        $this->error = [];
        $this->id = 0;
    }

    public function setData (): bool
    {
        if (empty($this->tableName)) {
            $this->setError('Error, no table name');
            return false;
        }

        return parent::setData();
    }

    public function setElement (): bool
    {
        $elementIds = explode(',', $_POST["element_ids"]);
        $blockValue = [];
        foreach ($elementIds as $id) {
            $queryValue = [
                "user_id" => $_POST["user_id"],
                "custom_package_id" => $_POST["custom_package_id"],
                "app_element_id" => $id
            ];
            $blockValue[] = '('.$this->getBlockValue('custom_element', $queryValue).')';
        }
        $blockValue = implode(',',$blockValue);
        return $this->setInsert('custom_element', $blockValue, true);
    }
}