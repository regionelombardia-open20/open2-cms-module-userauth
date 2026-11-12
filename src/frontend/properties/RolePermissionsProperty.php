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

namespace amos\userauth\frontend\properties;

use amos\userauth\frontend\Module;
use amos\userauth\frontend\utility\cmspageblock\CmsDataPageBlock;
use open20\amos\admin\models\UserProfileClassesAuthMm;
use open20\amos\community\utilities\CommunityUtil;
use luya\admin\base\CheckboxProperty;
use luya\admin\models\Config;
use luya\cms\frontend\events\BeforeRenderEvent;
use luya\cms\helpers\Url;
use luya\cms\menu\QueryOperatorFieldInterface;
use luya\cms\models\NavItem;
use mdm\admin\models\AuthItem;
use Yii;
use yii\helpers\ArrayHelper;

class RolePermissionsProperty extends CheckboxProperty {

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        $this->on(self::EVENT_BEFORE_RENDER, [$this, 'checkPermissions']);
    }

    /**
     * @inheritdoc
     */
    public function varName() {
        return 'rolePermissions';
    }

    public function type() {
        return self::TYPE_LIST_ARRAY;
    }

    /**
     * @inheritdoc
     */
    public function label() {
        return Module::t('#role_permissions_propety_label');
    }

    /**
     * @return mixed
     */
    public function listValues($enableProfile) {
        $encodedValue = $this->value;
        $values = [];
        $valuesDecoded = json_decode($encodedValue);
        foreach ($valuesDecoded as $val) {
            $values [] = $val->value;
        }

        if($enableProfile) {
            $result = [];
            $profiles = $values;
            foreach($profiles as $profileId) {
                $permissions = UserProfileClassesAuthMm::find()
                    ->select('item_id')
                    ->andWhere(['user_profile_classes_id' => $profileId])
                    ->asArray()
                    ->all();
                $permissions = ArrayHelper::map($permissions, 'item_id', 'item_id');
                $result[] = $permissions;
            }
            $values = $result;
        }
        return $values;
    }

    /**
     * @param $event
     * @param bool $no_exception true se si sta controllando i permessi per aggiornare Elastic Search
     * @param bool $ret_permissions
     * @return array|bool|mixed
     * @throws \yii\web\ForbiddenHttpException
     */
    public function checkPermissions($event = null, $no_exception = false, $ret_permissions = false) {

        // Se l'utente è ADMIN può vedere la pagina a prescindere
        if(!$no_exception && \Yii::$app->user->can('ADMIN')) {
            return true;
        }

        $enableProfile = false;
        $moduleDashboard = \Yii::$app->getModule('dashboards');
        if (!empty($moduleDashboard)) {
            if ($moduleDashboard->hasProperty('enableProfile') && $moduleDashboard->enableProfile) {
                $enableProfile = true;
            }
        }

        $values = $this->listValues($enableProfile);
        if ($ret_permissions) {
            return $values;
        }
        if (empty($values)) {
            return true;
        }

        if ($enableProfile) {
            if (!$no_exception && !\Yii::$app->user->isGuest) {
                foreach ($values as $profiles) {
                    $canAccess = true;
                    foreach ($profiles as $permission) {
                        $can = \Yii::$app->user->can($permission);
                        if (!$can) {
                            $canAccess = false;
                            break;
                        }
                    }
                    if($canAccess) {
                        return true;
                    }
                }
                if($canAccess) {
                    return true;
                } else if ($no_exception) {
                    return false;
                } else {
                    throw new \yii\web\ForbiddenHttpException(\Yii::t('amosapp', "Access denied."), 403);
                }
            }
        } else {
            if (!$no_exception && !\Yii::$app->user->isGuest) {
                foreach ($values as $permission) {
                    $can = \Yii::$app->user->can($permission);
                    if ($can) {
                        return true;
                    }
                }
            }
        }
        if ($no_exception) {
            return false;
        }
        throw new \yii\web\ForbiddenHttpException(\Yii::t('amosapp', "Access denied."), 403);
    }

    /**
     * @return array|mixed
     */
//    public function options() {
//        $options = [];
//        $roles = \Yii::$app->authManager->getRoles();
//        foreach ($roles as $role){
//            $options []= ['value' => $role->name, 'label' => $role->description];
//        }
//       return $options;
//    }
}
