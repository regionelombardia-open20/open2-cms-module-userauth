<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   amos\cms-module-userauth
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

namespace amos\userauth\models;

use amos\userauth\frontend\Module;
use open20\amos\core\helpers\Html;
use open20\amos\core\user\User;
use open20\amos\core\models\AmosModel;
use yii\base\Model;
use Yii;


class UserLoginForm extends AmosModel
{
    
    public $adminModule = null;
    
    
    /**
     * @var string The username
     */
    public $username;

    /**
     * @var string The password for a given username.
     */
    public $password;
    
    
    public $rememberme;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->rememberme = true;

        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'validateUser']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('userauth.models.user.username'),
            'password' => Module::t('userauth.models.user.password'),
            'rememberme' => Module::t('userauth.models.user.rememberme'),
        ];
    }

    /**
     * @inheritdoc
     * if enableEmailLogin is true, the username has to be an email. admin account escluded by this rule
     */
    public function rules()
    {
        /** @var Module $userAuthModule */
        $userAuthModule = Module::instance();
        return [
            [['username', 'password'], 'required'],
            [['username'], 'email', 'when' => function ($model) use ($userAuthModule) {

                if ($model->username != 'admin' && $userAuthModule->enableEmailLogin) {
                    return true;
                }
                return false;
            }, 'whenClient' => "function (attribute, value) {
                return ($('#" . Html::getInputId($this, 'username') . "').val() != 'admin' && " . ($userAuthModule->enableEmailLogin ? "true" : "false") . ");
            }"],
            [['rememberme'], 'safe']
        ];
    }

    /**
     * Validate the current input data against an user.
     *
     * @return boolean
     */
    public function validateUser()
    {
        // check if the user is an active user
        if ($this->user && ($this->user->status != 10)) {
            return $this->addError('username', Module::t('userauth.models.userloginform.error.username_not_active'));
        }
        
        if (!$this->user || !$this->validateInputPassword()) {
            return $this->addError('password',
                    Module::t('userauth.models.userloginform.error.username_password'));
        }
    }
    private $_user;

    /**
     * Get user object, contains false if not found.
     *
     * @return \luya\userauth\models\User|boolean
     */
    public function getUser()
    {
        if ($this->_user === null) 
        {
            if ($this->adminModule->allowLoginWithEmailOrUsername) 
            {
                $this->_user = self::findByUsernameOrEmail($this->username);
            }else
            {
                $this->_user = self::findByUsername($this->username);
            }
        }

        return $this->_user;
    }

    public function validateInputPassword()
    {
        $ret = false;
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $userauthModule = Yii::$app->getModule('userauthfrontend');
            if($userauthModule && $userauthModule->preventAdminLogin){
                if($user->username == 'admin') {return false;} // admin non può loggare normalmente
            }
            if ($user && !empty($user->password_hash) && $user->validatePassword($this->password)) {
                $ret = true;
            }
        }
        return $ret;
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username, 'status' => User::STATUS_ACTIVE]);
    }

    /**
     * Find inactive user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsernameInactive($username)
    {
        return User::findOne(['username' => $username, 'status' => User::STATUS_DELETED]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        $condition = ['email' => $email, 'status' => User::STATUS_ACTIVE];
        $allUsersByEmail = User::findAll($condition);
        if (count($allUsersByEmail) > 1) {
            return null;
        }
        return User::findOne($condition);
    }

    /**
     * Finds inactive user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmailInactive($email)
    {
        $condition = ['email' => $email, 'status' => User::STATUS_DELETED];
        $allUsersByEmail = User::findAll($condition);
        if (count($allUsersByEmail) > 1) {
            return null;
        }
        return User::findOne($condition);
    }

    /**
     * Finds user by username or email
     * if enableEmailLogin is true, find only by email, admin account excluded
     * @param string $usernameOrEmail
     * @return static|null
     */
    public static function findByUsernameOrEmail($usernameOrEmail)
    {
        /** @var Module $userAuthModule */
        $userAuthModule = Module::instance();
        
        if ($userAuthModule->enableEmailLogin) {
            if($usernameOrEmail == 'admin'){
                return self::findByUsername($usernameOrEmail);
            }
            return self::findByEmail($usernameOrEmail);
        }
        
        $user = self::findByUsername($usernameOrEmail);
        if (is_null($user)) {
            $user = self::findByEmail($usernameOrEmail);
        }
        return $user;
    }
}
