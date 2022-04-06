<?php

Autoloader::loadFile(FORM_PATH, ['CustomElement', 'AppElementOption'], 'Form');

class CustomElementRequest extends BaseRequest
{
    protected static function setContentBox (): void
    {
        $CustomPackage = new CustomPackageModel('custom_element');
        $id = AppRoute::getUrlParam(3);
        $id = is_int((int) $id) ? $id : "";

        self::setTpl (VIEW_PATH.'request/modalForm/contentBoxElement.tpl.php', [
            'entities' => $CustomPackage->getQuery('query', 'customElements', [$id]),
        ]);
    }

    protected static function setFormDelete ()
    {
        $Model = new CustomElementModel('custom_element');
        $id = AppRoute::getUrlParam(3);

        if (is_int((int) $id)) {
            $entity = $Model->getQuery('query', 'customElement', [(int) $id], true);
            $form = new CustomElementForm($entity);
            $formObject = $form->getForm();
            self::setTpl (VIEW_PATH.'request/modalForm/formDelete.tpl.php', [
                "id" => $formObject->id,
                "name" => $formObject->elementName["value"],
            ]);
        } else {
            self::setTpl (VIEW_PATH.'request/error.tpl.php', [
                "error" => "Fehler, keine Daten-ID gefunden.",
            ]);
        }
    }

    protected static function setFormAdd (): void
    {
        $id = AppRoute::getUrlParam(3);

        if (is_int((int) $id)) {
            $AppElement = new AppElementModel('app_element');
            $form = new AppElementOptionForm(
                ['custom_package_id' => $id, "user_id" => AppSession::getValue('userId') ?? "0"],
                array_merge($AppElement->getOptions(), ["css" => "search-selection"])
            );

            self::setTpl (VIEW_PATH.'request/modalForm/formBoxElement.tpl.php', [
                'appElements' => $AppElement->getQuery('query', 'appCustomPackageElements', [$id]),
                'form' => $form->getForm(),
                'package_id' => $id,
            ]);
        }
    }

    protected static function setAdd (): void
    {
        $Model = new CustomElementModel('custom_element');

        if ($Model->validate('customElement')) {
            if ($Model->setElements()) {
                $response = ['status' => 'success', 'msg' => "Die Daten wurde erfolgreich erstellt!"];
            } else {
                $response = ['status' => 'error', 'msg' => 'Datenbankfehler', 'errorMsg' => $Model->getError(true)];
            }
        } else {
            $response = ['status' => 'error', 'msg' => 'Die Daten konnte nicht gespeichert werden.', 'errorMsg' => AppValidator::getError(true)];
        }

        self::setResponse($response);
    }

    protected static function setDelete ()
    {
        $Model = new CustomElementModel('custom_element');

        if ($Model->validate('delete')) {
            if ($Model->setDelete()) {
                $response = ['status' => 'success', 'msg' => 'Die Daten wurden erfolgreich gelöscht!'];
            } else {
                $response = ['status' => 'error', 'msg' => 'Datenbankfehler', 'errorMsg' => $Model->getError(true)];
            }
        } else {
            $response = ['status' => 'error', 'msg' => 'Die Daten konnten nicht gelöscht werden.', 'errorMsg' => AppValidator::getError(true)];
        }

        self::setResponse($response);
    }
}