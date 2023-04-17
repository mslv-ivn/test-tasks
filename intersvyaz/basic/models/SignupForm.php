<?php

namespace app\models;

use Yii;

class SignupForm extends \yii\base\Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'validateUsername'],
            ['username', 'userExists'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
        ];
    }

    public function validateUsername($attribute, $params)
    {
        if (!preg_match("/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $this->$attribute)) {
            $this->addError($attribute, 'Имя пользователя должно состоять из 8-20 символов, подчеркивания и точки.');
        }
    }

    public function validatePassword($attribute, $params)
    {
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $this->$attribute)) {
            $this->addError($attribute, 'Пароль должен состоять минимум из восьми символов, одной буквы и одной цифры.');
        }
    }

    public function userExists($attribute, $params)
    {
        if (User::findIdentityByUsername($this->$attribute)) {
            $this->addError($attribute, 'Пользователь с таким именем уже существует.');
        }
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            return $user->save();
        }
        return false;
    }
}