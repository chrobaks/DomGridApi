<?php

require_once(VENDOR_PATH."phpmailer/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AppMailer
{
    private static $error;

    public static function sendMail ($configId, $mailParam)
    {
        // Set mail config
        $config = AppConfig::getConfig("mail", [$configId]);

        // Init instance PHPMailer
        $Mail = new PHPMailer(true);

        // Return true if mail send success
        $result = true;

        try {
            $Mail->IsSendmail();

            // Set encoding format
            $Mail->CharSet = 'UTF-8';
            $Mail->Encoding = 'base64';

            // Recipients
            $Mail->setFrom($config["emailFrom"]);
            $Mail->addAddress($mailParam["emailTo"]);
            $Mail->addReplyTo($config["replyTo"]);

            // Attachments array or string
            if (isset($mailParam["attachment"]) && !empty($mailParam["attachment"]))  {
                if(is_array($mailParam["attachment"])) {
                    foreach ($mailParam["attachment"] as $attachment) {
                        $Mail->addAttachment($attachment);
                    }
                } else {
                    $Mail->addAttachment($mailParam["attachment"]);
                }
            }

            // Content
            $Mail->isHTML(true); 
            $Mail->Subject = $mailParam["subject"];
            $Mail->Body    = $mailParam["body"];
            $Mail->AltBody = $mailParam["bodyAlt"];

            $Mail->send();

        } catch (Exception $e) {
            // Set error message
            self::setError($Mail->ErrorInfo);

            // Set return value to false
            $result = false;
        }

        //Clear all addresses and attachments for the next iteration
        $Mail->clearAddresses();
        $Mail->clearAttachments();

        return $result;
    }

    public static function getError () { return self::$error; }

    private static function setError ($error) { self::$error = $error; }
}
