<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   amos\userauth\frontend\views
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
use open20\amos\admin\AmosAdmin;
use open20\design\components\bootstrapitalia\ActiveForm;
use luya\helpers\Html;

$this->title = Module::t('#title_reset_password');
$textPwd = Module::t('#password_rules');

$form = ActiveForm::begin([
    'options' => [
        'class' => 'userauth-reset-pwd-form needs-validation form-rounded'
    ]
]);
?>
<div class="container py-4 my-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <h1 class="h2"><?= Module::t('#reset_password') ?></h1>
            <p class="mb-5"><?= Module::t('#reset_password_fill_the_form') ?></p>

            <div class="form-rounded">
            <?= $form->field($model, 'password')->PasswordInput([
                'label' => Module::t('Nuova password'),
                'placeholder' => Module::t('inserisci la nuova password'),
                'helperTooltip' => $textPwd,
                'enableStrengthMeter' => true,
                'data-enter-pass' => ''
            ])
            ?>

            <?= $form->field($model, 'ripetiPassword')->PasswordInput([
                'label' => Module::t('Conferma password'),
                'placeholder' => Module::t('conferma la nuova password'),
                //'enableStrengthMeter' => true
            ])
            ?>

                <div class="">
                    <?php if (!empty($isFirstAccess) && $isFirstAccess) : ?>
                        <div class="cookie-privacy">
                            <?=
                                Html::a(
                                    AmosAdmin::t('amosadmin', '#cookie_policy_message'),
                                    \Yii::$app->params['linkConfigurations']['cookiePolicyLinkCommon'],
                                    [
                                        'title' => AmosAdmin::t('amosadmin', '#cookie_policy_title'),
                                        'target' => '_blank'
                                    ]
                                )
                            ?>
                            <?= Html::tag('p', AmosAdmin::t('amosadmin', '#cookie_policy_content')) ?>
                            <div class="">
                                <?= $form->field($model, 'privacy')->radioList([
                                    1 => AmosAdmin::t('amosadmin', '#cookie_policy_ok'),
                                    0 => AmosAdmin::t('amosadmin', '#cookie_policy_not_ok')
                                ])->label('Privacy check',['class'=>'control-label sr-only']); ?>
                            </div>
                        </div>
                    <?php endif ?>
                </div>

            <?= $form->field($model, 'token')->hiddenInput()->label(false) ?>

            <?= Html::submitButton(
                'Aggiorna',
                [
                    'class' => 'btn btn-primary',
                    'name' => 'reset-pwd-button',
                    'title' => 'Conferma aggiornamento password']
            )
            ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
