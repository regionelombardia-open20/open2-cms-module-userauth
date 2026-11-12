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

namespace amos\userauth\models;

use amos\userauth\frontend\Module;
use open20\amos\core\record\Record;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class CredentialRequestForm
 *
 * This is the base-model class for table "credential_request".
 *
 * @property integer $id
 * @property string $nome
 * @property string $cognome
 * @property string $motivazione
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @package amos\userauth\models
 */

class CredentialRequestForm extends Record
{
    /**
     * @var int $privacy
     */
    public $privacy;

    /**
     * @var string $captcha
     */
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'credential_request';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => \Yii::t('userauth', 'Id'),
            'nome' => \Yii::t('userauth', 'Nome'),
            'cognome' => \Yii::t('userauth', 'Cognome'),
            'motivazione' => \Yii::t('userauth', 'Motivazioni della richiesta di credenziali'),
            'email' => \Yii::t('userauth', 'Email'),
            'created_at' => \Yii::t('userauth', 'Creato il'),
            'updated_at' => \Yii::t('userauth', 'Aggiornato il'),
            'deleted_at' => \Yii::t('userauth', 'Cancellato il'),
            'created_by' => \Yii::t('userauth', 'Creato da'),
            'updated_by' => \Yii::t('userauth', 'Aggiornato da'),
            'deleted_by' => \Yii::t('userauth', 'Cancellato da')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = ArrayHelper::merge(
            parent::rules(),
            [
                [['created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['motivazione'], 'string'],
                [['nome', 'cognome', 'email'], 'string', 'max' => 255],
                [['nome', 'cognome', 'email'], 'required'],
            ]
        );

        return $rules;
    }
}