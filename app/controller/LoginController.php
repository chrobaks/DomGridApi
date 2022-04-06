<?php

Autoloader::loadFile(FORM_PATH, ['Login'], 'Form');

class LoginController extends BaseController
{
    private UserModel $Model;
    private String $route;
    private String $loginRedirect;

    public function __construct ()
    {
        $this->Model = new UserModel();
        $this->route = AppConfig::getConfig('view', ['url']);
        $this->loginRedirect = '';
        $form = new LoginForm();
        $this->setView([
            'pageTitle' => 'Login',
            'form' => $form->getForm(),
        ]);
    }

    public function setLogin (): void
    {
        if (!$this->Model->validate('login')) {
            $this->setView(['formMsg' => 'Die Logindaten waren nicht vollständig']);
        } else {
            if ($this->Model->getLoginUser(AppValidator::getResult())) {
                if ($this->loginRedirect !== '') {
                    AppSession::setValues(['redirect' => '', 'redirectMsg' => '']);
                    $this->route .= $this->loginRedirect;
                }
                AppRedirect::setHeader($this->route);
            }else {
                $this->setView(['formMsg' => implode('<br>',$this->Model->error)]);
            }
        }
    }

    public function setResetPass (): void
    {
        $this->setView(['pageTitle' => 'Neues Passwort']);

        if (!$this->Model->validate('resetPass')) {
            $this->setView(['formMsg' => 'Die Formulardaten waren nicht vollständig']);
        } else {
            $_POST = AppValidator::getResult();
            $formMsg = "Deine Eingabedaten sind nicht korrekt";

            if ( ! $this->Model->getUserIsUnique($_POST['email'])) {
                $formMsg = "Der Vorgang war erfolgreich, öffne bitte dein Email-Postfach und folge der Anweisung in der Email, die wir dir geschickt haben.";
                $this->setView(['resetOk' => '1']);
            }
            $this->setView(['formMsg' => $formMsg]);
        }
    }
}