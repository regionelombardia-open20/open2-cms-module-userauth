<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\admin\views\security
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

use amos\userauth\frontend\Module;
use open20\amos\core\helpers\Html;
use open20\design\components\bootstrapitalia\ActiveForm;

$this->title = Module::t('Password dimenticata');

$referrer = \Yii::$app->request->referrer;
if ((strpos($referrer, 'javascript') !== false) || (strpos($referrer, \Yii::$app->params['backendUrl']) == false)) {
    $referrer = null;
}
?>

<div class="container py-4 my-5">
    <div class="row nop">
        <div class="col-md-6 mx-auto">


            <h2 class="title-login"><?= Module::t('#forgot_pwd_title'); ?></h2>
            <p class="mb-4"><?= Module::t('#forgot_pwd_subtitle'); ?></p>
            <div class="form-rounded">

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' =>
                    [
                        'class' => 'userauth-reset-pwd-form needs-validation form-rounded'
                    ]
                ]);
                ?>

                <?= $form->field($model, 'email') ?>

                <?= Html::a(Module::t('Annulla'), (strip_tags($referrer) ?: ['/site/login']), ['class' => 'btn btn-outline-primary pull-left', 'title' => Module::t('#go_to_login_title')]) ?>
                <?= Html::submitButton(Module::t('#reset_pwd_send'), ['class' => 'btn btn-primary btn-administration-primary pull-right', 'name' => 'login-button', 'title' => Module::t('#forgot_pwd_send_title')]) ?>


                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>