<?php

class CustomPackageForm extends BaseForm
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
            "userId" => $this->createInput([
                "name" => "user_id",
                "value" => $this->entity['user_id'] ?? "0",
                "required" => true,
            ], "hidden"),
            "packageName" => $this->createInput([
                "name" => "package_name",
                "value" => $this->entity['package_name'] ?? "",
                "label" => "Package Name",
                "placeholder" => "Name des Package",
                "required" => true,
            ]),
            "packageDescription" => $this->createInput([
                "name" => "package_description",
                "value" => $this->entity['package_description'] ?? "",
                "label" => "Beschreibung",
                "placeholder" => "Beschreibung des Package",
                "required" => true,
            ]),
            "packageVersion" => $this->createInput([
                "name" => "package_version",
                "value" => $this->entity['package_version'] ?? "",
                "label" => "Version",
                "placeholder" => "Version des Package",
                "required" => true,
                "css" => "inpt-short",
            ]),
        ];

        $this->createForm($form);
    }
}