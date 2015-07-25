<?php

class SignupForm extends CFormModel
{
    public $username;
    public $password;
    public $password1;
    public $icon;

    public function rules()
    {
        return array(
            // username and password are required
            array('username, password, password1', 'required', 'message' => '不能为空'),
            array('username', 'check_username'),
            array('password1', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码不相同'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'username' => '用户名',
            'password' => '密码',
            'password1' => '确认密码',
            'icon' => '选择头像',
        );
    }

    public function check_username()
    {
        $userModel = User::model();
        $userInfo = $userModel->find('username=:name', array(':name' => $this->username));
        if ($userInfo != NULL) {
            $this->addError('username', '该用户名已存在');
        }
    }

    public function signup()
    {
        $userModel = new User;
        $userModel->username = $_POST['SignupForm']['username'];
        $userModel->password = md5($_POST['SignupForm']['password']);
        $userModel->icon = $_POST['icon'];
        if ($userModel->save()) {
            $identity = new UserIdentity($_POST['SignupForm']['username'], $_POST['SignupForm']['password']);
            $identity->authenticate();
            Yii::app()->user->login($identity, 0);
            Yii::app()->user->setFlash('success', '注册成功');
            return true;
        } else
            return false;
    }
}
