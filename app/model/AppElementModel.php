<?php

class AppElementModel extends BaseModel
{
    public Array $error;
    private Int $id;

    public function __construct ($tableName = "")
    {
        parent::__construct($tableName);
        $this->error = [];
        $this->id = 0;
    }

    public function getOptions (): array
    {
        return [
            "status" => $this->getQuery('query', 'appOptionStatus'),
            "type" => $this->getQuery('query', 'appOptionType'),
            "environment" => $this->getQuery('query', 'appOptionEnvironment'),
        ];
    }

    public function setData (): bool
    {
        $action = ((int) $_POST['id'] === 0) ? "insert" : "update";
        $this->error = [];
        $result = true;

        if (empty($this->tableName)) {
            $this->setError('Error, no table name');
            return false;
        }

        if ($action === "insert") {
            $this->id = $this->setInsert($this->tableName, $_POST);
            // Return false if insert went wrong
            if ($this->id === 0) {
                $result = false;
                $this->setError('Add data false');
            }
        } else {
            $result = $this->setUpdate($this->tableName, $this->getPostUpdate($this->tableName));
        }

        return $result;
    }
}