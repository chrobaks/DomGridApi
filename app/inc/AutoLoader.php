<?php
/**
 * Static Class Autoloader
 * -----------------------------------------------------------
 * 
 */
class Autoloader
{
    public static function loadFile (String $path, Array $forms, String $postFix = ""): void
    {
        if (!empty($forms)) {
            $forms = $path. implode(','.$path, $forms);
            $forms = explode(',', $forms);
            foreach ($forms as $form) {
                $file = $form.$postFix.'.php';
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }
    }
    public static function getFiles ($autoload, $extendsFiles, $onlyFileName = false)
    {
        $result = $extendsFiles;

        foreach($autoload as $path) {

            $dirFiles = array_diff(scandir($path), array('..', '.'));
            $files = self::getFilePath($path, $dirFiles, $extendsFiles, $onlyFileName);

            if (!empty($files) ) {
                $result = array_merge($result, $files);
            }
        }

        return $result;
    }

    private static function getFilePath ($path, $files, $extendsFiles, $onlyFileName)
    {
        $result = [];
        foreach($files as $file) {
            if (!in_array($path.$file, $extendsFiles) && file_exists($path.$file)) {
                $result[] = ($onlyFileName) ? $file : $path.$file;
            }
        }

        return $result;
    }
}
