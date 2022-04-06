<?php

Autoloader::loadFile(FORM_PATH, ['CustomPackage','AppElementOption'], 'Form');

class CustomPackageRequest extends BaseRequest
{

    protected static function setContentPackage (): void
    {
        $Model = new CustomPackageModel('custom_package');
        $id = AppRoute::getUrlParam(3);
        $id = is_int((int) $id) ? $id : "";

        self::setTpl (VIEW_PATH.'request/modalForm/contentBoxPackageEntity.tpl.php', [
            'entity' => $Model->getQuery('query', 'customPackage', [$id], true),
        ]);
    }

    protected static function setContentBox (): void
    {
        $Model = new CustomPackageModel('custom_package');

        self::setTpl (VIEW_PATH.'request/modalForm/contentBoxPackage.tpl.php', [
            'entities' => $Model->getQuery('query', 'customPackages'),
        ]);
    }

    protected static function setFormDelete ()
    {
        $Model = new CustomPackageModel('custom_package');
        $id = AppRoute::getUrlParam(3);

        if (is_int((int) $id)) {
            $entity = $Model->getQuery('query', 'customPackage', [(int) $id], true);
            $form = new CustomPackageForm($entity);
            $formObject = $form->getForm();
            self::setTpl (VIEW_PATH.'request/modalForm/formDelete.tpl.php', [
                "id" => $formObject->id,
                "name" => $formObject->packageName["value"],
            ]);
        } else {
            self::setTpl (VIEW_PATH.'request/error.tpl.php', [
                "error" => "Fehler, keine Daten-ID gefunden.",
            ]);
        }
    }

    protected static function setFormAdd (): void
    {
        $Model = new CustomPackageModel('custom_package');
        $id = AppRoute::getUrlParam(3);
        $id = is_int((int) $id) ? $id : "";
        $entity = (empty($id))
            ? ["user_id" => AppSession::getValue('userId') ?? "0"]
            : $Model->getQuery('query', 'customPackage', [$id], true);

        $form = new CustomPackageForm($entity);

        self::setTpl (VIEW_PATH.'request/modalForm/formBoxPackage.tpl.php', [
            "form" => $form->getForm(),
        ]);
    }

    protected static function setAdd (): void
    {
        $Model = new CustomPackageModel('custom_package');

        if ($Model->validate('customPackage')) {
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
        $Model = new CustomPackageModel('custom_package');

        if ($Model->validate('delete')) {
            if ($Model->setDelete(["tbl" => "custom_element", "column" => "custom_package_id"])) {
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