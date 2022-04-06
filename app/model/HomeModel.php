<?php

class HomeModel extends BaseModel
{
    public $error;

    public function __construct ()
    {
        parent::__construct();
        $this->error = [];
    }
}