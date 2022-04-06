<?php

class LoginForm extends BaseForm
{
    public function __construct (Array $entity = [], Array $option = [])
    {
        parent::__construct($entity, $option);
        $this->setForm();
    }

    private function setForm (): void
    {
        $form = [
            "userName" => $this->createInput([
                "name" => "name",
                "value" => "",
                "label" => "Benutzername",
                "placeholder" => "Dein Benutzername",
                "required" => true,
                'css' => 'form-control',
            ]),
            "password" => $this->createInput([
                "name" => "pass",
                "value" => "",
                "label" => "Password",
                "placeholder" => "Dein Passwort",
                "required" => true,
                'css' => 'form-control',
            ], "password"),
            "btnSubmit" => $this->createButton([
                "name" => "btn-submit",
                "label" => "Login",
                "css" => "btn btn-primary btn-sm btn-fa",
                "icon" => "fa fa-sign-in-alt"
            ], "button"),
        ];

        $this->createForm($form);
    }
}