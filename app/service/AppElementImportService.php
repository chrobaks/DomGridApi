<?php

require_once FORM_PATH.'AppElementForm.php';

class AppElementImportService extends AppService
{
    private Array $import;
    private AppElementModel $entity;

    public function __construct ()
    {
        $this->entity = new AppElementModel('app_element');
    }

    public function getImport (): array
    {
        $options = $this->entity->getOptions();
        $appDirs = $this->entity->getQuery('query', 'elementTypeText', [], true);
        $appDirs = explode(',',$appDirs['type_text']);
        $appDirs = DOMGRID_JS_PATH.implode(','.DOMGRID_JS_PATH,$appDirs);
        $appDirs = explode(',',$appDirs);
        $formList = [];

        foreach($appDirs as $path) {
            $dirFiles = array_diff(scandir($path), array('..', '.'));
            $type = str_replace(DOMGRID_JS_PATH, '', $path);
            $elementType = $this->entity->getQuery('query', 'elementTypeValue', [$type], true);
            if(!empty($dirFiles)) {
                foreach($dirFiles as $file) {
                    $name = str_replace('.js', '', $file);
                    $idExist = $this->entity->getQuery('query', 'appElementExist', [$file, $name, $elementType['type_value']], true);
                    if (!isset($idExist["id"])) {
                        $result = [
                            'app_element_name' => $name,
                            'app_element_description' => 'Keine Beschreibung',
                            'app_element_source' => $file,
                            'app_element_version' => '1.0',
                            'app_element_type' => $elementType['type_value'],
                            'app_element_status' => "1",
                            'app_element_environment' => "3",
                        ];
                        $form = new AppElementForm($result, $options);
                        $formList[] = $form->getForm();
                    }
                }
            }
        }

        return $formList;
    }
}