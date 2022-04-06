<?php

class BaseService
{
    public $Model;
    protected $error;

    public function __construct ($Model)
    {
        $this->Model = $Model;
        $this->error = [];
    }

    public function getId ()
    {
        return $this->Model->getModelId();
    }

    public function getError ($toString = false)
    {
        $modelError = $this->Model->getError();

        if (!empty($modelError)) {
            $this->error = array_merge($this->error, $modelError);
        }
        $result = ($toString && !empty($this->error) && is_array($this->error)) ? implode("<br>", $this->error) : $this->error;

        return $result;
    }

    public function getInfo ($toString = false)
    {
        return $this->Model->getInfo($toString);
    }

    public function getModelId ()
    {
        return $this->Model->getModelId();
    }

    public function getHeaderTbl ($cat="")
    {
        return $this->Model->TableService->getHeader($cat);
    }

    public function getImportDataLength () { 
        return count($this->Model->importData);
    }

    public function isUpdate ()
    {
        return $this->Model->isUpdate();
    }

    protected function setError ($error)
    {
        $this->error[] = $error;
    }
    
    protected function hasError ()
    {
        return count($this->getError());
    }

}