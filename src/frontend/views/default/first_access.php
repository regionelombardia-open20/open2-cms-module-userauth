<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\basic\template
 * @category   CategoryName
 */

use luya\helpers\Html;
use amos\userauth\frontend\Module;
use open20\design\components\bootstrapitalia\ActiveForm;

$this->title = 'Primo accesso';
$textPwd = Module::t('#password_rules');

$form = ActiveForm::begin([
    'options' => [
        'class' => 'userauth-first-access-form needs-validation form-rounded'
    ]
]);
?>

<div class="container py-4 my-5">
    <div class="row nop">
        <div class="col-md-6 mx-auto">
            <h1 class="h2">Primo accesso</h1>
            <p class="mb-5"><?= Module::t('#first_access_fill_the_form') ?></p>
            <div class="form-rounded">
                <div class="">
                    <?= $form->field($model, 'username')->textInput() ?>
                </div>

                <div>
<?php /**                    <?= $form->field($model, 'password')->passwordInput([
                        'label' => Module::t('Nuova password'),
                        'placeholder' => Module::t('inserisci la nuova password'),
                        'helperTooltip' => $textPwd,
                        'enableStrengthMeter' => true,
                        'data-enter-pass' => ''
                    ])
                    ?>
                    
         */ ?>
                    
                            <?= $form->field($model, 'password')->widget(PasswordInput::class, [
            'language' => 'it',
            'options' => [
                'autocomplete' => 'off'
            ],
            'pluginOptions' => [
                'showMeter' => true,
                'toggleMask' => true,
                'language' => 'it'
            ]
        ])
        ?>

                </div>

                <?= $form->field($model, 'ripetiPassword')->passwordInput([
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
                                ]); ?>
                            </div>
                        </div>
                    <?php endif ?>
                </div>

                <?= $form->field($model, 'token')->hiddenInput()->label(false) ?>

                <?= Html::submitButton('Conferma', ['class' => 'btn btn-primary', 'name' => 'first-access-button', 'title' => 'Conferma inserimento credenziali']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>