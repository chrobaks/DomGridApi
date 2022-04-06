<?php

class AppSession
{
    public static function startSession ()
    {
        session_start();

        // Store current Sess Id
        $currentSessId = session_id();

        // Store 1 if sess is bad
        $sessReLogin = 0;

        
        // Set relogin flag if session out of time
        // if (ENVIROMENT === 'localhost' && self::isUsersession() && !self::checkCookie($currentSessId)) {
        //     $sessReLogin = 1;
        // }
        
        // refresh cookie
        self::setSessCookie();
        
        $_SESSION['sessId'] = session_id();
        $_SESSION['sessOwner'] = SESS_COOKIE_NAME;
        $_SESSION['user'] = (self::hasValue('user')) ? $_SESSION['user'] : '';
        $_SESSION['userId'] = (self::hasValue('userId')) ? $_SESSION['userId'] : '';
        $_SESSION['realName'] = (self::hasValue('realName')) ? $_SESSION['realName'] : '';
        $_SESSION['role'] = (isset($_SESSION['role'])) ? $_SESSION['role'] : '-1';
        $_SESSION['redirect'] = (isset($_SESSION['redirect'])) ? $_SESSION['redirect'] : '';
        $_SESSION['redirectMsg'] = (isset($_SESSION['redirectMsg'])) ? $_SESSION['redirectMsg'] : '';
        $_SESSION['sessReLogin'] = $sessReLogin;
        $_SESSION['lang'] = (isset($_SESSION['lang'])) ? $_SESSION['lang'] : AppConfig::getConfig('view', ['lang_default']);
    }

    public static function updateSession ($user)
    {
        // Regenerate Sess Id
        session_regenerate_id(true);

        $_SESSION['sessId'] = session_id();
        $_SESSION['user'] = $user['name'];
        $_SESSION['realName'] = $user['realname'];
        $_SESSION['userId'] = $user['id'];
        $_SESSION['role'] = $user['role'];
    }
    
    public static function getSessionUser ()
    {
        return (self::hasValue('user')) ? $_SESSION['user'] : '';
    }

    public static function resetSession ()
    {
        session_destroy();
        session_start();
        session_regenerate_id(true);
        $_SESSION['user'] = '';
        $_SESSION['userId'] = '';
        $_SESSION['realName'] = '';
        $_SESSION['role'] = '-1';
        $_SESSION['redirect'] = '';
        $_SESSION['redirectMsg'] = '';
        $_SESSION['sessId'] = '';
        $_SESSION['sessOwner'] = '';

        self::setSessCookie();
    }

    public static function isUsersession ()
    {
        $isUserSession = false;

        if (isset($_SESSION['user']) 
            && !empty($_SESSION['user']) 
            && isset($_SESSION['role']) 
            && $_SESSION['role'] !== '-1') 
        {
            $isUserSession = true;
        }

        return $isUserSession;
    }

    public static function setValues ($values)
    {
        if (!empty($values)) {
            foreach((array) $values as $key => $val) {
                $_SESSION[$key] = $val;
            }
        }
    }

    public static function hasValue ($key)
    {
        return (isset($_SESSION[$key]) && !empty($_SESSION[$key])) ? true : false;
    }

    public static function hasRelogin ()
    {
        return (isset($_SESSION["sessReLogin"]) && (int)($_SESSION["sessReLogin"]) === 1) ? true : false;
    }

    public static function getValue ($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : '';
    }
    
    private static function checkCookie ($currentSessId)
    {
        $result = false;

        if (isset($_COOKIE[SESS_COOKIE_NAME])) {

            $result = true;
            $cookie = json_decode($_COOKIE[SESS_COOKIE_NAME]);
            $now = time();
            
            // Check cookie expires & current Sess Id
            if ($cookie->expires <= $now || $cookie->sessId !== $currentSessId) {
                $result = false;
            }
        }

        return $result;
    }

    public static function setSessCookie ()
    {
        $expires = time()+3600;
        $newSessId = session_id();
        $cookieData = (object)["sessId" => $newSessId, "expires" => $expires];

        setcookie(SESS_COOKIE_NAME, json_encode($cookieData), [
            'expires' =>  $expires,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'SameSite' => 'Strict',
        ]);
    }
}
