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

namespace amos\userauth\frontend\utility\cmspageblock;

use Exception;
use luya\cms\models\Block;
use luya\cms\models\NavItemPageBlockItem;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\log\Logger;

abstract class CmsPageBlock extends NavItemPageBlockItem
{

    /**
     *
     * @param array $values
     * @return array
     */
    protected function flatArray(array &$values)
    {
        foreach ($values as $keys => $value) {
            if (is_array($value)) {
                $this->flatArray($value);
                $values = ArrayHelper::merge($values, $value);
                unset($values[$keys]);
            }
        }
    }

    /**
     *
     * @param string $name
     * @return Block
     */
    protected static function findBlock(string $name): Block
    {
        $block = null;

        try {
            $block = Block::findOne(['class' => $name]);
        } catch (Exception $ex) {
            Yii::getLogger()->log($ex->getTraceAsString(), Logger::LEVEL_ERROR);
        }
        return $block;
    }

    public abstract static function findBlocks($nav_item_page_id);

    /**
     *
     * @return array
     */
    public function getCfgValues()
    {
        $values = Json::decode($this->json_config_values);
        return $values;
    }
}