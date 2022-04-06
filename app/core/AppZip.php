<?php

class AppZip
{
    private static $error = [];

    public static function setZipDownload ($zipName)
    {
        self::$error = [];

        try {
            if (file_exists($zipName)) {
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="'.basename($zipName).'"');
                header('Content-Length: ' . filesize($zipName));
                header("Pragma: no-cache"); 
                header("Expires: 0"); 
                flush();
                readfile($zipName);
                unlink($zipName);
            } else {
                self::setError("Kein Download-Zip gefunden.");
            }
        } catch (exception $e) {
            if (!empty($e)) {
                self::setError($e->getMessage());
            }
        }

        return (empty(self::$error)) ? true : false;
    }

    public static function setZipDir ($attachmentPath, $zipName, $attachments = [])
    {
        self::$error = [];

        try {
            $zip = new ZipArchive;
            $unlinks = [];

            if ($zip->open(EXPORT_PATH.$zipName, ZipArchive::CREATE) === TRUE) {

                foreach ( $attachments as $attachment) {
                    $zip->addFile($attachmentPath.$attachment, $attachment);
                    $unlinks[] = $attachmentPath.$attachment;
                }

                $zip->close();

                if (!file_exists(EXPORT_PATH.$zipName)) {
                    self::setError('Fehler bei der Erstellung des ZIP-Ordners.');
                }

                FileHandler::setUnlink($unlinks);

            } else {
                self::setError('Der ZIP-Ordner konnte nich angelegt werden.');
            }
        } catch (exception $e) {
            if (!empty($e)) {
                self::setError($e->getMessage());
            }
        }
        

        return (empty(self::$error)) ? true : false;
    }

    public static function getError ()
    {
        return self::$error;
    }

    private static function setError ($error) {
        self::$error[] = $error;
    }
}