<?php

class BaseRequest
{
    public static $response = ['status'=>'error', 'msg'=>'Applikations-Fehler, bitte wende dich an den Support!'];

    public static function setRequest ($Controller, $action)
    {
        $method = 'set'.ucfirst($action);

        if (method_exists( $Controller ,$method)) {
            // If it is a data processing request
            if (!preg_match("/^form/", $action) && AppSession::hasRelogin()) { // Call relogin
                self::setRelogin();
            } else { // Run request method
                $Controller::{$method}();
            }
        } else {
            self::setResponse();
        }
    }
    
    public static function setBadRequest ($message = "")
    {
        self::setResponse(['status'=>'error', 'msg'=>'URL-Fehler, bitte wende dich an den Support! '.$message]);
    }

    public static function setFormError ($error)
    {
        self::setTpl (VIEW_PATH.'/request/modalError.tpl.php',['error' => $error]);
    }

    public static function getUrlList ()
    {
        $result = [];
        $request  = (ENVIROMENT === 'localhost') ? str_replace("/".APP_Name."/", "", $_SERVER['REQUEST_URI']) : substr($_SERVER['REQUEST_URI'], 1);

        if (!empty($request)) {
            $result = explode("/", $request);
        }

        return $result;
    }

    public static function getRequestParam ($request, $propKeys)
    {
        $result = [];

        if (!empty($propKeys)) {
            foreach($propKeys as $key) {
                $result[$key] = (isset($request[$key])) ? trim($request[$key]) : '';
            }
        }

        return $result;
    }
    
    protected static function isAdminRequest ()
    {
        return (AppSession::getValue('role') === '1' && count($_POST) > 0) ? true : false;
    }

    protected static function setRelogin ()
    {
        self::setResponse(['relogin' => AppRoute::getRoute(['home', "relogin"])]);
    }

    protected static function setResponse ($response = [])
    {
        if (!empty($response)) {
            echo json_encode($response);
        } else {
            echo json_encode(self::$response);
        }
        
        exit();
    }

    protected static function setTpl ($tplUrl, $view = [])
    {
        include_once $tplUrl;
        exit(0);
    }

    protected static function getTpl ($tplUrl, $view = [])
    {
        if ( !file_exists( $tplUrl ) ) {
            return '';
        }

        ob_start();
        include $tplUrl;
        return ob_get_clean();
    }
}