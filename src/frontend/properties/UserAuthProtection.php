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
use open20\amos\community\utilities\CommunityUtil;
use luya\admin\base\CheckboxProperty;
use luya\admin\models\Config;
use luya\cms\frontend\events\BeforeRenderEvent;
use luya\cms\helpers\Url;
use luya\cms\menu\QueryOperatorFieldInterface;
use luya\cms\models\NavItem;
use Yii;
use yii\helpers\ArrayHelper;

class UserAuthProtection extends CheckboxProperty {

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        $this->on(self::EVENT_BEFORE_RENDER, [$this, 'ensureUserAccess']);
    }

    /**
     * Check whether the current page requires protection and user is logged in.
     *
     * @param BeforeRenderEvent $event
     */
    public function ensureUserAccess(BeforeRenderEvent $event) {
        if ($this->getValue() == 1) {
            if (Yii::$app->user->isGuest) {
                throw new \yii\web\ForbiddenHttpException(Module::t('Non hai i privilegi per visualizzare la pagina.'));
                // find the nav item to redirect from config
//                $navItem = Yii::$app->menu->find()->where([QueryOperatorFieldInterface::FIELD_NAVID => Config::get(Module::USERAUTH_CONFIG_REDIRECT_NAV_ID)])->with([
//                        'hidden'])->one();
//throw new  yii\web\NotFoundHttpException(Module::t('Non hai i privilegi per visualizzare la pagina.'));
//                // redirect to the given nav item
//                return Yii::$app->response->redirect($navItem->absoluteLink.'?redir='.urlencode($event->menu->absoluteLink));
            } else {
                if (!$this->canSeePage()) {
                    throw new \yii\web\ForbiddenHttpException(Module::t('Non hai i privilegi per visualizzare la pagina.'));
//                    $navItem = Yii::$app->menu->find()->where([QueryOperatorFieldInterface::FIELD_NAVID => Config::get(Module::NOPERMISSION_CONFIG_REDIRECT_NAV_ID)])->with([
//                            'hidden'])->one();
//                    if ($navItem !== false) {
//                        // redirect to the given nav item
//                        return Yii::$app->response->redirect($navItem->absoluteLink);
//                    }else{
//                        return Yii::$app->response->redirect(Url::home(true));
//                    }
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function varName() {
        return 'userAuthProtection';
    }

    /**
     * @inheritdoc
     */
    public function label() {
        return Module::t('userauth.propertie.userauthprotection.label');
    }

    /**
     *
     */
    protected function canSeePage() {
        $canSee = false;
        $canPermission = false;
        $nav = Yii::$app->menu->current;
        $nav_item = NavItem::findOne(['nav_id' => $nav->itemArray['nav_id']]);
        $propertyPermissions = $nav->getProperty('rolePermissions');
        $noComm = false;
        $noPerm = false;
        if (!empty($propertyPermissions)) {
            $canPermission = $propertyPermissions->checkPermissions();
        } else {
            $noPerm = true;
        }
        
        if (!is_null($nav_item)) {
            $values = $this->getBlockConfigValues($nav_item->nav_item_type_id,
                    CmsDataPageBlock::class);
            if (isset($values['community_id'])) {
                $canSee = CommunityUtil::userIsCommunityMember($values['community_id'],
                                \Yii::$app->user->id);
            } else {
                $noComm = true;
            }
        }

        return ($noComm && $noPerm) || $canPermission || $canSee;
    }

    /**
     *
     * @param integer $nav_item_page_id
     * @param type $class_
     * @return array
     */
    protected function getBlockConfigValues($nav_item_page_id, $class_) {
        $items = [];
        $blocks = $this->findBlockModules($nav_item_page_id, $class_);
        foreach ($blocks as $block) {
            $items = ArrayHelper::merge($items, $block->getCfgValues());
        }
        return $items;
    }

    /**
     *
     * @param type $nav_item_page_id
     * @param type $class_
     * @return type
     */
    protected function findBlockModules($nav_item_page_id, $class_) {
        $blocks = $class_::findBlocks($nav_item_page_id);
        return $blocks;
    }

}
