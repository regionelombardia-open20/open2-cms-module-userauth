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

namespace amos\userauth\admin;

use luya\admin\base\Module;
use luya\admin\components\AdminMenuBuilder;


class Module extends Module
{
    public $apis = [
        'api-userauth-user' => 'amos\userauth\admin\apis\UserController',
    ];

    public function getMenu()
    {
        return (new AdminMenuBuilder($this))
                ->node('userauthadmin.admin.menu.node', 'verified_user')
                ->group('userauthadmin.admin.menu.group')
                ->itemApi('userauthadmin.admin.menu.item.user',
                    'userauthadmin/user/index', 'verified_user',
                    'api-userauth-user');
    }

    /**
     * @inheritdoc
     */
    public static function onLoad()
    {
        self::registerTranslation('userauthadmin',
            static::staticBasePath().'/messages',
            [
            'userauthadmin' => 'userauthadmin.php',
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('userauthadmin', $message, $params);
    }
}