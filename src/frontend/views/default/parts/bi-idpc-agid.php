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

use amos\userauth\frontend\Module;;

use open20\amos\core\helpers\Html;
use yii\helpers\Url;

/**
 * @var $socialAuthModule \open20\amos\socialauth\Module
 */
$socialAuthModule = Yii::$app->getModule('socialauth');

?>
<?php if ($socialAuthModule && $socialAuthModule->enableAgidLogin) : ?>
  <?php if (!$hideIdpcAgidButtonInfo) : ?>
    <div class="border-bottom border-light pb-3 mb-4">
      <?php if (!$hideIdpcAgidButtonTitle) : ?>
        <p class="h5"><?= Module::t('Accedi con idPC AGID') ?></p>
      <?php endif ?>
      <?php if (!$hideIdpcAgidButtonSubtitle) : ?>
        <p class="mb-0"><?= Module::t('Sistema di Identity Provider di AGID') ?></p>
      <?php endif ?>
    </div>
  <?php endif ?>
  <?=
  Html::a(
    Html::tag('span', Module::t('Accedi con la tua identità digitale')),
    Url::to('/socialauth/agid-login/connect', 'https'),
    [
      'class' => 'btn btn-icon rounded-0 btn-spid text-uppercase',
      'title' => Module::t('Accedi con la tua identità digitale AGID'),
    ]
  )
  ?>


<?php endif ?>