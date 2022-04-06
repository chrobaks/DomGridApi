<?php

class UserModel extends BaseModel
{
    public $error;
    private $userId;

    public function __construct ()
    {
        parent::__construct();
        $this->error = [];
        $this->userId = 0;
    }

    public function getLoginUser ($user)
    {
        $result = $this->getQuery("query", 'loginUser', [$user['name']], true);
        $loginOk = false;

        if (!empty($result) && password_verify($user['pass'], $result['pass'])) {

            if (!empty(AppConfig::getConfig('route', ['userLandingpage']))) {
                AppSession::setValues(['redirect' => AppConfig::getConfig('route', ['userLandingpage'])]);
            }

            AppSession::updateSession($result);
            $loginOk = true;
            
        }else {
            $this->error[] = 'Die Logindaten waren nicht korrekt.';
        }
        
        return $loginOk;
    }

    public function getUser ($getSessUser = true, $userId = 0)
    {
        if ((int) $userId > 0) {
            $result = $this->getQuery("query", 'userById', [$userId], true);
        } elseif ($getSessUser) {
            $sessUser = AppSession::getSessionUser();
            $result = $this->getQuery("query", 'loginUser', [$sessUser], true);
        } else {
            $result = $this->getQuery("query", 'user');
        }
        
        return $result;
    }

    public function getUserIsUnique ($user)
    {
        $result = $this->getQuery("query", 'loginUser', [$user], true);

        return !isset($result['id']);
    }

    public function setProfil ()
    {
        $_POST = AppValidator::setValidation('profil', $_POST);

        // If $_POST isn't valid
        if (!AppValidator::isValid()) {
            $this->setError(AppValidator::getError());
            return false;
        }

        // Check Update user
        if ($this->setUpdate('user', $this->getPostUpdate('user'))) { // Update session user realname
            AppSession::setValues(["realName" => $_POST["realname"]]);

            return true;
        }
        
        return false;
    }

    public function setUser ()
    {
        // Leave if no id is set
        if (!isset($_POST['id'])) {return false;}

        // Set validation id for new user (signUp) or update (user)
        $vaidationId = ((int)  $_POST['id'] === 0) ? "signUp" : "user";

        // Get validation results
        $_POST = AppValidator::setValidation($vaidationId, $_POST);

        if (!AppValidator::isValid()) { return false; }
        
        if ($vaidationId === "signUp") { // Add new user
            // Create apssword hash
            $_POST["pass"] = password_hash($_POST['pass'], PASSWORD_DEFAULT);

            // Insert data and get user id
            $this->userId = $this->setInsert('user', $_POST);

            // Return false if insert went wrong
            if ($this->userId === 0) { return false; }

        } else { // Update user
            $this->setUpdate('user', $this->getPostUpdate('user'));
        }

        return (empty($this->modelError)) ? true : false;
    }

    public function updateUser($id, $form) 
    {
        return $this->setUpdate('user', $form, $id);
    }

    public function deleteUser ()
    {
        if(isset($_POST['id']) && is_numeric($_POST['id'])) {
            return $this->setQuery('deleteUser', [$_POST['id']]);
        }
        return false;
    }
}
