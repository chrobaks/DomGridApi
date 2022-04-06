<?php

class IndexController
{
    private static $instance;
    private BaseView $View;

    public function __construct ()
    {
        $this->View = BaseView::get_instance();
        $this->UserModel = new UserModel();
    }

    public static function get_instance()
    {
        if( ! isset(self::$instance)){self::$instance = new IndexController();}

        return self::$instance;
    }

    public function setRouteController ()
    {
        // Set route params
        AppRoute::setRoute();
        // Filter post values
        AppValidator::setValidPost();

        if (AppRoute::getIsRequest()) { // It's a ajax request route
            return false;
        } else { // It's a page route
            // Set login from user view call because cookie time out of range
            if (isset($_SESSION["sessReLogin"]) && (int)$_SESSION["sessReLogin"] === 1) {
                AppSession::resetSession();
                AppRedirect::setHeader(AppRoute::getRoute(['login']));
            }
            // Get route controller instance
            $Controller = AppRoute::getRouteControllerInst();
            // Set general view params
            $this->View->setView([
                "page" => AppRoute::getRouteController(),
                "pageAction" => AppRoute::getRouteAction(),
            ]);
            // Set controller view params      
            $this->View->setView($Controller->getView());

            return true;
        }
    }

    public function setRequest () { AppRoute::setRequest(); }

    public function getView () {
        return $this->View->getView();
    }
}
