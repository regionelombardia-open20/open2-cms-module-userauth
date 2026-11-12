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

namespace VENDOR\NAME\tests;

use luya\testsuite\cases\WebApplicationTestCase;
use luya\userauth\frontend\controllers\DefaultController;
use luya\userauth\frontend\controllers\LogoutController;

class FrontendTest extends WebApplicationTestCase
{
    public function getConfigArray()
    {
        return [
            'id' => 'packagetest',
            'basePath' => __DIR__,
            'language' => 'en',
        ];
    }

    public function testControllers()
    {
        $default = new DefaultController('default', $this->app);
        $logout = new LogoutController('logout', $this->app);

        $this->assertNotNull($default);
        $this->assertNotNull($logout);
    }
}
