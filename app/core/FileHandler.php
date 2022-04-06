<?php

class FileHandler
{
   public static function setMultipleUpload ($appDir, $pathDir, $inptName, $extensions, $setTimeStamp = true)
   {
      if (isset($_FILES[$inptName]) && count($_FILES[$inptName]["name"])) {

         $fileCount = count($_FILES[$inptName]["name"]);
         $errorCount = 0;
         $maxSize = AppConfig::getConfig('import',['max_upload_file']);
         $timeStamp = date('Y-d-m-H-i-s');
         $errorResults = [];

         for ($i = 0; $i < $fileCount; $i++) {
            $file_name = ($setTimeStamp) ? $timeStamp.'-'.basename($_FILES[$inptName]['name'][$i]) : basename($_FILES[$inptName]['name'][$i]);
            $file_size = $_FILES[$inptName]['size'][$i];
            $file_tmp = $_FILES[$inptName]['tmp_name'][$i];
            $real_name = explode('.',$_FILES[$inptName]['name'][$i]);
            $file_ext = strtolower(end($real_name));
            $error = [];

            if(!self::hasValidExtensions($file_ext,$extensions)){
               $error[] = "Der Dateitype $file_ext wird nicht unterstützt: ".basename($_FILES[$inptName]['name'][$i]);
            }

            if($file_size > $maxSize) {
               $error[] = 'Die Datei darf nicht mehr als 100 MB haben:'.basename($_FILES[$inptName]['name'][$i]);
            }

            if ($pathDir !== '') { $pathDir = $pathDir.DIRECTORY_SEPARATOR; }

            if(empty($error)) {
               // Delete file if exist
               if (file_exists($appDir.$pathDir.$file_name)) {unlink($appDir.$pathDir.$file_name);}

               // Check file is zip
               if ($file_ext === "zip") {
                  if ( ! self::zipExtract ($file_tmp, $appDir.$pathDir)) {
                     $error[] = 'Die Zip-Datei konnte nicht entpackt werden: '.basename($_FILES[$inptName]['name'][$i]);
                  }
               } else { // Add new file
                  if (!move_uploaded_file($file_tmp, $appDir.$pathDir.$file_name)) {
                     $error[] = 'Die Datei konnte nicht gespeichert werden: '.basename($_FILES[$inptName]['name'][$i]);
                  }
               }
            }

            if (!empty($error)) { 
               $errorResults = array_merge($errorResults, $error);
               $errorCount++; 
            }
         }

         return ["fileCount" => $fileCount, "errorCount" => $errorCount, "errors" => $errorResults];

      } else {
         return ["fileCount" => 0, "errorCount" => 1, "errors" => ["Es wurden keine Dateien gefunden."]];
      }
   }

   public static function setUpload ($appDir, $pathDir, $inptName, $extensions, $setTimeStamp = true)
   {
      $error = [];
      $file_name = '';
      $file_ext = '';

      if (!is_uploaded_file($_FILES[$inptName]['tmp_name'])) {
         $error[] = 'Die Datei konnte nicht hochgeladen werden.';
      }
      
      if (empty($error) && isset($_FILES[$inptName])) {
         $timeStamp = date('Y-d-m-H-i-s');
         $file_name = ($setTimeStamp) ? $timeStamp.'-'.basename($_FILES[$inptName]['name']) : basename($_FILES[$inptName]['name']);
         $file_size = $_FILES[$inptName]['size'];
         $file_tmp = $_FILES[$inptName]['tmp_name'];
         $file_type = $_FILES[$inptName]['type'];
         $real_name = explode('.',$_FILES[$inptName]['name']);
         $file_ext = strtolower(end($real_name));
         
         if(in_array($file_ext,$extensions) === false){
            $error[] = "Der Dateitype wird nicht unterstützt: $file_ext";
         }
         
         if($file_size > AppConfig::getConfig('import',['max_upload_file'])) {
            $error[] = 'Die Datei darf nicht mehr als 100 MB haben.';
         }

         if ($pathDir !== '') {
            $pathDir = $pathDir.DIRECTORY_SEPARATOR;
         }
         
         if(empty($error) === true) {
            if (!move_uploaded_file($file_tmp, $appDir.$pathDir.$file_name)) {
               $error[] = 'Die Datei konnte nicht gespeichert werden.';
            }
         }
      }

      return ['fileName' => $file_name, 'fileExt' => $file_ext, 'error' => $error];
   }

   public static function setUnlink ($arrFiles)
   {
      if(!empty($arrFiles)) {
         foreach ($arrFiles as $file) {if (file_exists($file)) {unlink($file);}}
      }
   }

   private static function zipExtract ($zipFIle, $extractTo)
   {
      $zip = new ZipArchive;
      $result = false;

      if ($zip->open($zipFIle) === TRUE) {
          $zip->extractTo($extractTo);
          $zip->close();
          $result = true;
      }

      return $result;
   }

   private static function hasValidExtensions ($file_ext, $extensions)
   {
      return in_array($file_ext,$extensions); 
   }
}