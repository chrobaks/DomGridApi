<?php 

class AppRoute
{
    private static $route;
    private static $routeConfig;
    private static $urlList;
    private static $isRequest;

    public static function setRoute ()
    {
        self::$route = ['controller' => '','action' => ''];
        self::$routeConfig = array_merge([], AppConfig::getConfig('route'));
        self::$urlList = AppRequest::getUrlList();

        // Set route controller / route action / isRequest
        self::setRouteParam();

        // Is page route, no ajax request, than validate route
        if (!self::$isRequest) { self::setRouteValidation(); }
    }

    public static function getUrlList (): array
    {
        return self::$urlList;
    }

    public static function getUrlParam ($index): string|int
    {
        $requestParam = self::getUrlList();

        return $requestParam[3] ?? "";
    }
    
    public static function getRoute ($route): string
    {
        $url = AppConfig::getConfig('view', ['url']);
        $route = (is_array($route) && !empty($route)) ? implode('/', $route) : $route;

        return $url.$route;
    }
    
    public static function getRouteController () { return self::$route['controller']; }
    
    public static function getRouteAction () { return self::$route['action']; }
    
    public static function getIsRequest () { return self::$isRequest; }

    public static function getRouteControllerInst ()
    {
        // Create controller name
        $ControllerClass = ucfirst(self::$route['controller']).'Controller';
        // Set controller instance
        $ControllerInstance = new $ControllerClass();
        // Call controller action if valid
        self::setControllerAct($ControllerClass, $ControllerInstance);

        return $ControllerInstance;
    }

    public static function setRequest ()
    {
        if (self::setRequestRoute()) {

            // Create controller name
            $RequestClass = (self::$route['controller'] === "request") ? "AppRequest" : ucfirst(self::$route['controller']).'Request';

            if (method_exists($RequestClass, "setRequest") && is_callable([$RequestClass, "setRequest"], true)) {
                $RequestClass::setRequest($RequestClass, self::$route['action']);
            } else {
                AppRequest::setBadRequest("Method not found");
            }
        } else {
            AppRequest::setBadRequest("Route not found");
        }
    }

    private static function setRequestRoute ()
    {
        // Create access path from route
        $strRoute = (self::$route["controller"] === "request") 
            ? self::$route["controller"].".".self::$route["action"]             // Default request Controller AppRequest
            : "request.".self::$route["controller"].".".self::$route["action"]; // Registered request Controller (route.config -> requestController)

        // Check access path private / admin
        if (AppSession::isUsersession() && (int) AppSession::getValue('role') === 0 && in_array($strRoute, self::$routeConfig['request']['private'])
            || AppSession::isUsersession() && (int) AppSession::getValue('role') === 1 && in_array($strRoute, self::$routeConfig['request']['admin'])
            || !AppSession::isUsersession() && in_array($strRoute, self::$routeConfig['request']['public'])) {
            return true;
        } else if (self::$route['action'] === "relogin") { // Ajax request if session is bad, send a relogin order to view
            return true;
        }

        return false;
    }

    private static function setControllerAct ($controllerClass, $controllerInstance)
    {
        $act = (!empty(self::$route['action'])) ? 'set' . ucFirst(trim(self::$route['action'])) : '';

        if ($act !== '') {
            
            $methodVariable = array($controllerInstance, $act);

            if (method_exists($controllerClass, $act) && is_callable($methodVariable, true)) {
                $controllerInstance->{$act}();
            }
        }
    }

    private static function setRouteParam ()
    {
        // Set route controller name
        self::$route["controller"] = (!empty(self::$urlList)) 
            ? self::$urlList[0] 
            : ((!AppSession::isUsersession()) ? self::$routeConfig["customerLandingpage"] : self::$routeConfig["userLandingpage"]);

        // Set route action name
        self::$route["action"] = (!empty(self::$urlList) && count(self::$urlList) > 1) ? self::$urlList[1] : "";

        // Set route isRequets flag
        self::$isRequest = (!empty(self::$urlList) && self::$urlList[0] === 'request') ? true : false;
        
        // Set request Controller
        if (self::$isRequest && in_array(self::$route["action"], self::$routeConfig["requestController"])) {
            self::$route["controller"] = self::$urlList[1];
            self::$route["action"] = self::$urlList[2];
        }
    }

    private static function setRouteValidation ()
    {
        $strRoute = (empty(self::$route["action"])) ? self::$route["controller"] : self::$route["controller"].".".self::$route["action"];

        if (!AppSession::isUsersession()) { // Default Session with customer
            if (!in_array($strRoute, self::$routeConfig["public"])) {
                self::$route["controller"] = self::$routeConfig["customerLandingpage"];
                self::$route["action"] = "";
            }
        } else {// User Session with role 0=private / 1=admin
            if ( AppSession::getValue('role') === '0' && !in_array($strRoute, self::$routeConfig["private"])
                || AppSession::getValue('role') === '1' && !in_array($strRoute, self::$routeConfig["admin"])) {
                self::$route["controller"] = self::$routeConfig["userLandingpage"];
                self::$route["action"] = "";
            }
        }
    }
}
