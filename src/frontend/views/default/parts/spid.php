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

use open20\amos\admin\AmosAdmin;
use open20\amos\core\helpers\Html;
use open20\amos\admin\assets\ModuleAdminAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use open20\amos\core\icons\AmosIcons;
use yii\helpers\Url;

ModuleAdminAsset::register(Yii::$app->view);



?>
<?= Html::tag('h2', AmosAdmin::t('amosadmin', '#fullsize_spid'), ['class' => 'title-login']) ?>
<div class="col-sm-6 col-xs-12 nop">
    <?=
    Html::a(
        AmosIcons::show('account-circle') . AmosAdmin::t('amosadmin', '#fullsize_login_spid_text'),
        Url::to('/socialauth/shibboleth/endpoint', 'https'),
        [
            'class' => 'btn btn-spid',
            'title' => AmosAdmin::t('amosadmin', '#fullsize_login_spid_text'),
            //'target' => '_blank'
        ]
    )
    ?>
</div>
<div class="col-xs-12 nop">
    <p class="spid-text"><?= AmosAdmin::t('amosadmin', '#fullsize_login_spid_text_right') ?></p>
</div>
