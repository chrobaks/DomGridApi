<?php

class LogoutController extends BaseController
{
    public function __construct ()
    {
        AppSession::resetSession();
        AppRedirect::setHeader(AppConfig::getConfig('view', ['url']).AppConfig::getConfig('route', ['customerLandingpage']));
    }
}
