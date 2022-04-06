<?php

class AppValidator
{
    private static array $error;
    private static array $result;

    public static function setValidation ($validationId, $data): void
    {
        $config = AppConfig::getConfig('validation', ['form']);
        self::$result = [];
        self::$error = [];
        if (is_array($data) && !empty($data) && isset($config[$validationId]) ) {
            $validation = $config[$validationId];
            self::validate($validation, 'required', $data, $validationId);
            if (isset($validation['optional'])) {
                self::validate($validation, 'optional', $data, $validationId);
            }
        } else {
            self::$error[] = "Keine Validierungs-Daten gefunden.";
        }
    }

    public static function isValid (): bool
    {
        return empty(self::$error);
    }

    public static function getError ($toString = false): string|array
    {
        return ($toString && !empty(self::$error) && is_array(self::$error))
            ? implode("<br>", self::$error)
            : self::$error;
    }

    public static function getResult (): array
    {
        return self::$result;
    }

    private static function validate ($validation, $validationKey, $data, $validationId): void
    {
        $errConf = AppConfig::getConfig('validation', ['errorMsg']);
        $errMsg = $errConf[$validationId] ?? '';

        foreach($validation[$validationKey] as $key) {
            $val = (isset($data[$key])) ? trim($data[$key]) : '';
            if ($val !== '') {
                if (self::hasRuleKey($validation, $key)) {
                    if ($validation['rules'][$key] === "email") {
                        self::setEmail($key, $val, $errMsg);
                    } else if ($validation['rules'][$key] === "date") {
                        self::setDate($key, $val, $errMsg);
                    } else if (str_starts_with($validation['rules'][$key], "password_")) {
                        $passArgs = explode("_", $validation['rules'][$key]);
                        if (strlen($val) < (int)$passArgs[1]) {
                            self::$error[] = (!$errMsg) ? $key.'='.$val : $errMsg[$key].':'.$val;
                        } else {self::setResult($key, $val);}
                    } else {
                        self::setRuleValue($validation, $key, $val, $errMsg);
                    }
                } else {
                    self::setResult($key, $val);
                }
            } else {
                if ($validationKey === 'required') {
                    self::$error[] = $errMsg[$key] ?? $key;
                }
            }
        }
    }

    public static function setValidPost (): void
    {
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if (empty($_POST) && $contentType !== "") {
            $fetchContent = trim(file_get_contents("php://input"));
            $_POST = json_decode($fetchContent, true);
        }
        if (!empty($_POST)) {
            foreach ($_POST as $k => $v) {
                $v = trim($v);
                $_POST[$k] = strip_tags(htmlentities(stripslashes($v)));
            }
        }
    }

    private static function setDate ($key, $val, $errMsg): void
    {
        $reg = '/^[\d]{2}(.|-|\/)[\d]{2}(.|-|\/)[\d]{4}$/';
        if (!preg_match($reg, $val)) {
            self::$error[] = (!$errMsg) ? $key.'='.$val : $errMsg[$key].':'.$val;
        } else {
            setlocale (LC_ALL, "de_DE");
            $date = strtotime($val);
            $val = date('Y-m-d', $date);
            self::setResult($key, $val);
        }
    }

    private static function setEmail ($key, $val, $errMsg)
    {
        if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
            self::$error[] = (!$errMsg) ? $key.'='.$val : $errMsg[$key].':'.$val;
        } else {self::setResult($key, $val);}
    }

    private static function setRuleValue ($validation, $key, $val, $errMsg)
    {
        if (!preg_match($validation['rules'][$key], $val)) {
            self::$error[] = (!$errMsg) ? $key.'='.$val : $errMsg[$key].':'.$val;
        } else {self::setResult($key, $val);}
    }

    private static function setResult ($key, $val): void
    {
        self::$result[$key] = $val;
    }

    private static function hasRuleKey (Array $validation, String $key): bool
    {
        return !!(isset($validation['rules']) && isset($validation['rules'][$key]));
    }
}