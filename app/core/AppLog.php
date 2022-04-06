<?php
class AppLog
{
    public static function log ($arrData, $file = '', $path = '')
    {
        try {
            $file = (empty($file)) ? "log.txt" : $file;
            $path = (empty($path)) ? LOG_LOCAL_PATH : $path;

            if (!empty($arrData) && is_array($arrData)) {

                $date = "[".date("d.m.Y-H:i:s")."] ";
                
                foreach ($arrData as $data) { file_put_contents($path.$file, $date.$data."\r\n", FILE_APPEND | LOCK_EX); }
            }
        } catch (exception $e) {
        }
    }
}