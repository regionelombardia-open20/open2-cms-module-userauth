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

namespace  amos\userauth\frontend\utility\cmspageblock;

use amos\userauth\frontend\utility\cmspageblock\CmsPageBlock;
use app\modules\cmsapi\frontend\utility\CmsBlocksBuilder;
use yii\helpers\Json;

class CmsDataPageBlock extends CmsPageBlock
{

    /**
     *
     * @param type $nav_item_page_id
     * @return array
     */
    public static function findBlocks($nav_item_page_id)
    {
        $id_block = static::findBlock(CmsBlocksBuilder::DATA);
        $blocks   = static::find()->
            andWhere(['nav_item_page_id' => $nav_item_page_id])->
            andWhere(['block_id' => $id_block->id])
            ->all();
        return $blocks;
    }

    /**
     *
     * @return type
     */
    public function getCfgValues()
    {
        $values = [];
        $items  = Json::decode($this->json_config_values);
        if (!empty($items['items'])) {
            foreach ($items['items'] as $item) {
                $values[$item['variable']] = $item['value'];
            }
        }
        return $values;
    }
}