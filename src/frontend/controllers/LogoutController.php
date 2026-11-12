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

namespace amos\userauth\frontend\controllers;

use luya\web\Controller;
use Yii;
use yii\filters\HttpCache;
use yii\web\Response;


class LogoutController extends Controller
{

    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            'httpCache' => [
                'class' => HttpCache::class,
                'cacheControlHeader' => 'no-store, no-cache',
                'lastModified' => function ($action, $params) {
                    return time();
                },
            ],
        ];
    }

    /**
     * Ensure logout and redirect to home page.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        Yii::$app->user->logout();
        if(\Yii::$app instanceof \open20\amos\core\applications\CmsApplication)
        {
            \Yii::$app->session->set('access_token', null);

        }

        return $this->goHome();
    }
}