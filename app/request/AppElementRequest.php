<?php

Autoloader::loadFile(FORM_PATH, ['AppElement'], 'Form');

class AppElementRequest extends BaseRequest
{
    protected static function setFormAppElement ()
    {
        $Model = new AppElementModel('app_element');
        $form = new AppElementForm([], $Model->getOptions());

        self::setTpl (VIEW_PATH.'request/modalForm/formAddAppElement.tpl.php', [
            "form" => $form->getForm(),
        ]);
    }

    protected static function setFormImport ()
    {
        $Service = new AppElementImportService();

        self::setTpl (VIEW_PATH.'request/modalForm/formImportAppElement.tpl.php', [
            'forms' => $Service->getImport(),
            'importView' => VIEW_PATH.'request/modalForm/formImportAppElement.tpl.php',
        ]);
    }

    protected static function setFormDelete ()
    {
        $Model = new AppElementModel('app_element');
        $id = AppRoute::getUrlParam(3);
        $id = is_int((int) $id) ? (int) $id : "";

        if ($id) {
            $entity = $Model->getQuery('query', 'appElement', [$id], true);
            $form = new AppElementForm($entity);
            $formObject = $form->getForm();
            self::setTpl (VIEW_PATH.'request/modalForm/formDelete.tpl.php', [
                "id" => $formObject->id,
                "name" => $formObject->appElementName["value"],
                "msg" => "Es werden auch alle Elemente aus den Custom Packages entfernt.",
            ]);
        } else {
            self::setTpl (VIEW_PATH.'request/error.tpl.php', [
                "error" => "Fehler, keine Daten-ID gefunden.",
            ]);
        }
    }

    protected static function setFormEdit ()
    {
        $Model = new AppElementModel('app_element');
        $id = AppRoute::getUrlParam(3);
        $id = is_int((int) $id) ? (int) $id : "";

        if ($id) {
            $entity = $Model->getQuery('query', 'appElement', [$id], true);
            $form = new AppElementForm($entity, $Model->getOptions());
            self::setTpl (VIEW_PATH.'request/modalForm/formAddAppElement.tpl.php', [
                "form" => $form->getForm(),
            ]);
        } else {
            self::setTpl (VIEW_PATH.'request/error.tpl.php', [
                "error" => "Fehler, keine Kampagnen-ID gefunden.",
            ]);
        }
    }

    protected static function setAdd ()
    {
        $Model = new AppElementModel('app_element');

        if ($Model->validate('appElement')) {
            if ($Model->setData()) {
                $msg = ((int) $_POST["id"] > 0) ? 'Die Daten wurden erfolgreich geändert!' : 'Die Daten wurde erfolgreich erstellt!';
                $response = ['status' => 'success', 'msg' => $msg];
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
        $Model = new AppElementModel('app_element');

        if ($Model->validate('appElementDelete')) {
            if ($Model->setDelete(["tbl" => "custom_element", "column" => "app_element_id"])) {
                $response = ['status' => 'success', 'msg' => 'Die Daten wurden erfolgreich gelöscht!'];
            } else {
                $response = ['status' => 'error', 'msg' => 'Datenbankfehler', 'errorMsg' => $Model->getError(true)];
            }
        } else {
            $response = ['status' => 'error', 'msg' => 'Die Daten konnten nicht gelöscht werden.', 'errorMsg' => AppValidator::getError(true)];
        }

        self::setResponse($response);
    }

    protected static function setDataTable ()
    {
        // Model Instance
        $Model = new DataTableModel("app_element", ["stepLen" => 50]);
        $results = $Model->getData('appElements');
        $status = (!empty($results)) ? "success" : "error";

        $response = ['status' => $status, 'dataTable' => $results];

        self::setResponse($response);
    }
}