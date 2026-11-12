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
use amos\userauth\frontend\Module;

$this->title = Module::t( "Rinconciliazione completata");
?>
<div class="container py-5">

    <div class="col-xs-12">
        <h4><?= Module::t("Gentile {nome} {cognome},<br> grazie per aver riconciliato il tuo profilo Open Innovation con la tua Identità Digitale.", [
                'nome' => $model->nome,
                'cognome' => $model->cognome,
            ]) ?>
            <br><br>
            <?= Module::t("Clicca <a href='/'>qui</a> per accedere alla piattaforma") ?>
        </h4>
    </div>
</div>
