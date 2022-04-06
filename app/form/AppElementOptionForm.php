<?php

class AppElementOptionForm extends BaseForm
{
    public function __construct(array $entity = [], array $option = [])
    {
        parent::__construct($entity, $option);
        $this->setForm();
    }

    private function setForm(): void
    {
        $form = [
            "customPackageId" => $this->createInput([
                "name" => "custom_package_id",
                "value" => $this->entity['custom_package_id'] ?? "0",
                "required" => true,
            ], "hidden"),
            "userId" => $this->createInput([
                "name" => "user_id",
                "value" => $this->entity['user_id'] ?? "0",
                "required" => true,
            ], "hidden"),
            "appElementType" => $this->createSelect([
                "option" => $this->option["type"] ?? [],
                "name" => "app_element_type",
                "value" => $this->entity['app_element_type'] ?? "placeholder",
                "label" => "AppElement Type",
                "css" => $this->option['css'] ?? "",
                "placeholder" => "Auswahl",
            ]),
            "appElementStatus" => $this->createSelect([
                "option" => $this->option["status"] ?? [],
                "name" => "app_element_status",
                "value" => $this->entity['app_element_status'] ?? "placeholder",
                "label" => "AppElement Status",
                "css" => $this->option['css'] ?? "",
                "placeholder" => "Auswahl",
            ]),
            "appElementEnvironment" => $this->createSelect([
                "option" => $this->option["environment"] ?? [],
                "name" => "app_element_environment",
                "value" => $this->entity['app_element_environment'] ?? "placeholder",
                "label" => "AppElement Bereich",
                "css" => $this->option['css'] ?? "",
                "placeholder" => "Auswahl",
            ]),
        ];

        $this->createForm($form);
    }
}