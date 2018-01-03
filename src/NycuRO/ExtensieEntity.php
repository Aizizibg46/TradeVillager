<?php

declare(strict_types = 1);

namespace NycuRO;

use pocketmine\entity\Entity;

/**
 * author: NycuRO
 * TradeVillager Project
 */
class ExtensieEntity extends Entity {

    public static function init(): void{
        self::registerEntity(Cow::class, false, ['Cow', 'minecraft:cow']);
    }
}