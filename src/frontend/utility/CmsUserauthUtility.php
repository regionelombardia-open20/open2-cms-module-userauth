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

/**
 * Created by PhpStorm.
 * User: michele.lafrancesca
 * Date: 24/09/2021
 * Time: 10:41
 */

namespace amos\userauth\frontend\utility;


use yii\validators\IpValidator;

class CmsUserauthUtility
{
    /**
     * @return bool
     */
    public static function isAccessPermitted()
    {
        $ip = null;
        $allowed1  = false;
        $allowed2  = false;
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip1 =  $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        if(!empty($_SERVER['REMOTE_ADDR'])){
            $ip2 =  $_SERVER['REMOTE_ADDR'];
        }


        if(!empty($ip1)){
            $allowedIPs = [];
            $module = \Yii::$app->getModule('admin');
            if($module){
                $allowedIPs = \Yii::$app->params['loginAllowedIPs'];
            }
            $ipValidator = new IpValidator(['ranges' => $allowedIPs]);
            $allowed1 = $ipValidator->validate($ip1);
        }

        if(!empty($ip2)){
            $allowedIPs = [];
            $module = \Yii::$app->getModule('admin');
            if($module){
                $allowedIPs = \Yii::$app->params['loginAllowedIPs'];
            }
            $ipValidator = new IpValidator(['ranges' => $allowedIPs]);
            $allowed2 = $ipValidator->validate($ip2);
        }

        return ($allowed1 || $allowed2);
    }


}