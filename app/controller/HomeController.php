<?php

Autoloader::loadFile(FORM_PATH, ['AppElementOption'], 'Form');

class HomeController extends BaseController
{
    public function __construct ()
    {
        $User = new UserModel();
        $CustomPackage = new CustomPackageModel('custom_package');
        $CustomElement = new CustomElementModel('custom_element');
        $Service = new AppElementImportService();
        $AppElement = new AppElementModel('app_element');
        $formElementOption = new AppElementOptionForm([], array_merge($AppElement->getOptions(), ["css" => "search-selection"]));
        $this->setView([
            'pageTitle' => 'Home',
            'menuGroup' => 'Home',
            'pageAct' => 'home',
            'user' => $User->getUser(true),
            'forms' => $Service->getImport(),
            'formElementOption' => $formElementOption->getForm(),
            'importView' => VIEW_PATH.'request/modalForm/formImportAppElement.tpl.php',
            'entities' => $CustomPackage->getQuery('query', 'customPackages'),
            'customPackageView' => VIEW_PATH.'request/modalForm/contentBoxPackage.tpl.php',
        ]);
    }

    public function setRelogin ()
    {
        AppSession::resetSession();
        AppRedirect::setHeader(AppRoute::getRoute(['login']));     
    }
}
