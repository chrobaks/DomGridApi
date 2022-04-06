<?php

class CustomElementForm extends BaseForm
{
    public function __construct (Array $entity = [], Array $option = [])
    {
        parent::__construct($entity, $option);
        $this->setForm();
    }

    private function setForm (): void
    {
        $form = [
            "id" => $this->createInput([
                "name" => "id",
                "value" => $this->entity['id'] ?? "0",
                "required" => true,
            ], "hidden"),
            "elementName" => $this->createInput([
                "name" => "app_element_name",
                "value" => $this->entity['app_element_name'] ?? "",
                "label" => "Element Name",
                "placeholder" => "Name des Element",
                "required" => true,
            ]),
        ];

        $this->createForm($form);
    }
}