<?php

class AppElementForm extends BaseForm
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
                "value" => AppSession::getValue('userId') ?? "0",
                "required" => true,
            ], "hidden"),
            "appElementName" => $this->createInput([
                "name" => "app_element_name",
                "value" => $this->entity['app_element_name'] ?? "",
                "label" => "AppElement Name",
                "placeholder" => "Name des AppElement",
                "required" => true,
            ]),
            "appElementDescription" => $this->createInput([
                "name" => "app_element_description",
                "value" => $this->entity['app_element_description'] ?? "",
                "label" => "Beschreibung",
                "placeholder" => "Beschreibung des AppElement",
                "required" => true,
            ]),
            "appElementSource" => $this->createInput([
                "name" => "app_element_source",
                "value" => $this->entity['app_element_source'] ?? "",
                "label" => "Dateiname",
                "placeholder" => "Dateiname des AppElement",
                "required" => true,
            ]),
            "appElementVersion" => $this->createInput([
                "name" => "app_element_version",
                "value" => $this->entity['app_element_version'] ?? "",
                "label" => "Version",
                "placeholder" => "Version des AppElement",
                "required" => true,
                "css" => "inpt-short",
            ]),
            "stableDateStart" => $this->createInput([
                "name" => "stable_date_start",
                "value" => $this->entity['stable_date_start'] ?? "",
                "label" => "Gültig von",
                "placeholder" => "dd.mm.yyyy",
                "required" => true,
                "css" => "date-picker date-from",
                "data" => ['data-min-range="1440"'],
            ]),
            "stableDateEnd" => $this->createInput([
                "name" => "stable_date_end",
                "value" => $this->entity['stable_date_end'] ?? "",
                "label" => "Gültig bis",
                "placeholder" => "dd.mm.yyyy",
                "required" => true,
                "css" => "date-picker date-to",
            ]),
            "appElementType" => $this->createSelect([
                "option" => $this->option["type"] ?? [],
                "name" => "app_element_type",
                "value" => $this->entity['app_element_type'] ?? "placeholder",
                "label" => "AppElement Type",
                "placeholder" => "Auswahl AppElement-Type",
                "required" => true,
            ]),
            "appElementStatus" => $this->createSelect([
                "option" => $this->option["status"] ?? [],
                "name" => "app_element_status",
                "value" => $this->entity['app_element_status'] ?? "placeholder",
                "label" => "AppElement Status",
                "placeholder" => "Auswahl AppElement-Status",
                "required" => true,
            ]),
            "appElementEnvironment" => $this->createSelect([
                "option" => $this->option["environment"] ?? [],
                "name" => "app_element_environment",
                "value" => $this->entity['app_element_environment'] ?? "placeholder",
                "label" => "AppElement Bereich",
                "placeholder" => "Auswahl AppElement-Bereich",
                "required" => true,
            ]),
        ];

        $this->createForm($form);
    }
}