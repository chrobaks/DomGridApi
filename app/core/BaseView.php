<?php

class BaseView
{
    
    private static $instance;
    private $view;

    public function __construct () {
        $this->view = AppConfig::getConfig('view');
    }

    public static function get_instance(){
        if( ! isset(self::$instance)){self::$instance = new BaseView();}

        return self::$instance;
    }

    public function setView ($model)
    {
        if (is_array($model) && !empty($model)) {
            foreach($model as $key => $val) {
                $this->view[$key] = $val;
            }
        }
    }

    public function getView ()
    {
        return $this->view;
    }
}
