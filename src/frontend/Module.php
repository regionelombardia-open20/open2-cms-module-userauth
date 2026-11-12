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

namespace amos\userauth\frontend;

use luya\base\Module as BaseModule;

class Module extends BaseModule
{

    const USERAUTH_CONFIG_REDIRECT_NAV_ID = 'userauth_redirect_nav_id';
    const USERAUTH_CONFIG_AFTER_LOGIN_NAV_ID = 'userauth_afterlogin_nav_id';
    const NOPERMISSION_CONFIG_REDIRECT_NAV_ID = 'nopermission_redirect_nav_id';

    private static $moduleName = 'userauthfrontend';
    public $enableSPID = false;
    public $enableSocial = false;
    public $enableAgidLogin = false;
    public $enablePuaLogin = false;
    public $enableRegister = true;
    public $enableCredentialRequest = false;
    public $enableRegisterModuleName = 'organizzazioni';
    public $enableRegisterContext = false;
    public $enableEmailLogin = false;
    public $enableUserPasswordLogin = true;
    public $hideResetPasswordLogin = false;
    public $showLoginStandardUnderVpn = false;
    public $enableOverrideSPIDemail = false;
    public $enableDlSemplificationLight = false;
    public $viewLayout = null;

    /** @var float|int @DEPRECATED */
    public $remember_length = 8600 * 24 * 30;

    /**
     * @var bool $precompileUsernameOnFirstAccess
     */
    public $precompileUsernameOnFirstAccess = false;

    /**
     * @var bool $redirectLinkInRegister
     */
    public $redirectLinkInRegister = false;

    /**
     * @var bool $preventAdminLogin
     */
    public $preventAdminLogin = false;

    public static function getModuleName()
    {
        return static::$moduleName;
    }

    public static function setModuleName($name)
    {
        static::$moduleName = $name;
    }


    public function init()
    {
        parent::init();
    }

    /**
     * Return an instance of module
     *
     * @return AmosModule
     */
    public static function instance()
    {
        /*         * @var AmosModule $module */
        $module = \Yii::$app->getModule(static::getModuleName());
        return $module;
    }

    /**
     *
     * @param string $url
     * @return string
     */
    public static function toUrlModule($url)
    {
        return '/' . static::getModuleName() . $url;
    }

    /**
     * @inheritdoc
     */
    public static function onLoad()
    {
        self::registerTranslation('userauth',
            static::staticBasePath() . '/messages',
            [
                'userauth' => 'userauth.php',
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('userauth', $message, $params);
    }

}
