<?php

declare(strict_types = 1);

namespace NycuRO;

use pocketmine\entity\Animal;
use pocketmine\item\Item;

/**
 * author: NycuRO
 * TradeVillager Project
 */
class Cow extends Animal {

    const NETWORK_ID = self::COW;

    public $width = 0.3;
    public $length = 0.9;
    public $height = 0.0;

    /**
     * @return string
     */
    public function getName() : string{
        return "Cow";
    }

    /**
     * @return array
     */
    public function getDrops() : array{
        /** @var array $drop */
        $drop = [
            Item::get(Item::RAW_BEEF, 0, mt_rand(1, 3)),
            Item::get(Item::LEATHER, 0, mt_rand(0, 2)),
        ];
        return $drop;
    }
}
