<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $userInfo = User::model()->find('username=:name', array(':name' => $this->username));
        if ($userInfo == NULL) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }
        if ($userInfo->password !== md5($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        }
        $this->_id = $userInfo->id;
        // Yii::app()->session['userId']=$userInfo->id;
        //Yii::app()->session['credit']=$userInfo->credit;
        //Yii::app()->session['lv']=$userInfo->getLevel();
        $this->errorCode = self::ERROR_NONE;
        return true;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId()
    {
        return $this->_id;
    }
}