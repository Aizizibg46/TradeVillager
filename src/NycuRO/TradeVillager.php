<?php

declare(strict_types = 1);

namespace NycuRO;

use onebone\economyapi\EconomyAPI;
use pocketmine\entity\{Entity, Villager};
use pocketmine\event\entity\{EntityDamageByChildEntityEvent, EntityDamageByEntityEvent, EntityDamageEvent
};
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\inventory\PlayerInventory;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\particle\HeartParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\{
    ModalFormResponsePacket, ModalFormRequestPacket, PacketPool
};
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

/**
 * author: NycuRO
 * TradeVillager Project
 */
class TradeVillager extends PluginBase implements Listener {


    public $baniDeMuls = "";
    public $sansaSaPrimestiLapte = "";
    public $mesajMuls = "";
    public $mesajNereusitaMuls = "";
    public $mesajSatean = "";
    public $mesajPrimestiBaniSatean = "";
    public $mesajNuAreGaleata = "";
    public $mesajAnulareSchimbCuSatean = "";
    public $numeVillagerMenu = "";
    public $mesajVillagerMenu = "";
    public $optiuneVillagerMenu = "";
    public $titlePrimestiBaniSatean = "";
    public $titleNuAreGaleata = "";
    public $titleAnulareSchimbCuSatean = "";
    public $titleMuls = "";
    public $titleNereusitaMuls = "";
    public $buttonMessageOne = "";
    public $buttonMessageTwo = "";
    public $itemPrimitVaca;
    public $metadataPrimitVaca;
    public $itemCedatVaca;

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $files = array("config.yml");
        foreach($files as $file){
            if(!file_exists($this->getDataFolder() . $file)) {
                @mkdir($this->getDataFolder());
                file_put_contents($this->getDataFolder() . $file, $this->getResource($file));
            }
        }
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->baniDeMuls = $this->cfg->get("baniDeMuls");
        $this->sansaSaPrimestiLapte = $this->cfg->get("sansaSaPrimestiLapte");
        $this->mesajMuls = $this->cfg->get("mesajMuls");
        $this->mesajNereusitaMuls = $this->cfg->get("mesajNereusitaMuls");
        $this->mesajSatean = $this->cfg->get("mesajSatean");
        $this->mesajPrimestiBaniSatean = $this->cfg->get("mesajPrimestiBaniSatean");
        $this->mesajNuAreGaleata = $this->cfg->get("mesajNuAreGaleata");
        $this->mesajAnulareSchimbCuSatean = $this->cfg->get("mesajAnulareSchimbCuSatean");
        $this->numeVillagerMenu = $this->cfg->get("numeVillagerMenu");
        $this->mesajVillagerMenu = $this->cfg->get("mesajVillagerMenu");
        $this->optiuneVillagerMenu = $this->cfg->get("optiuneVillagerMenu");
        $this->titlePrimestiBaniSatean = $this->cfg->get("titlePrimestiBaniSatean");
        $this->titleNuAreGaleata = $this->cfg->get("titleNuAreGaleata");
        $this->titleAnulareSchimbCuSatean = $this->cfg->get("titleAnulareSchimbCuSatean");
        $this->titleMuls = $this->cfg->get("titleMuls");
        $this->titleNereusitaMuls = $this->cfg->get("titleNereusitaMuls");
        $this->buttonMessageOne = $this->cfg->get("buttonMessageOne");
        $this->buttonMessageTwo = $this->cfg->get("buttonMessageTwo");
        $this->itemCedatVaca = $this->cfg->get("itemCedatVaca");
        $this->itemPrimitVaca = $this->cfg->get("itemPrimitVaca");
        $this->metadataPrimitVaca = $this->cfg->get("metadataPrimitVaca");
        $this->saveDefaultConfig();
        $this->reloadConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        ExtensieEntity::init();
    }

    /**
     * @param EntityDamageEvent $event
     * @return bool
     */
    public function onDamage(EntityDamageEvent $event) {
        /** @var Entity $entity */
        $entity = $event->getEntity();
        if ($entity === NULL) {
            return true;
        }
        /** @var Player $damager */
        $damager = NULL;
        /** @var PlayerInventory $inventory */
        $inventory = NULL;
        /** @var Level $level */
        $level = NULL;
        if ($event instanceof EntityDamageByEntityEvent) {
            /** @var EntityDamageByEntityEvent $ev */
            $ev = $event;
            /** @var Entity $entity */
            $entity = $event->getEntity();
            if ($ev instanceof EntityDamageByChildEntityEvent) {
                /** @var EntityDamageByChildEntityEvent $evc */
                $evc = $ev;
                if ($evc->getDamager() instanceof Player) {
                    /** @var Player $damager */
                    $damager = $evc->getDamager();
                    /** @var PlayerInventory $inventory */
                    $inventory = $damager->getInventory();
                    /** @var Level $level */
                    $level = $damager->getLevel();
                }
            } else if ($ev->getDamager() instanceof Player) {
                /** @var Player $damager */
                $damager = $ev->getDamager();
                /** @var PlayerInventory $inventory */
                $inventory = $damager->getInventory();
                /** @var Level $level */
                $level = $damager->getLevel();
            }
            if ($damager === NULL) {
                return true;
            }
            /** @var Item $itemHand */
            $itemHand = $inventory->getItemInHand();
            if ($entity instanceof Cow and $inventory->getItemInHand()->getId() == $this->itemCedatVaca) {
                $laSuta = $this->sansaSaPrimestiLapte;
                if (mt_rand(0, 100) <= $laSuta) {
                    $inventory->remove($itemHand);
                    /** @var Vector3 $x */
                    $x = $entity->getX();
                    /** @var Vector3 $y */
                    $y = $entity->getY();
                    /** @var Vector3 $z */
                    $z = $entity->getZ();
                    $level->addParticle(new HeartParticle(new Vector3($x + 0.5, $y + 2, $z + 0.5)));
                    $level->addParticle(new HeartParticle(new Vector3($x + 1, $y + 1, $z + 1)));
                    $level->addParticle(new HeartParticle(new Vector3($x + 0.5, $y + 1, $z + 0.5)));
                    $level->addParticle(new HeartParticle(new Vector3($x - 0.5, $y + 1, $z + 0.5)));
                    $level->addParticle(new HeartParticle(new Vector3($x + 0.5, $y + 1, $z -0.5)));
                    $inventory->addItem(Item::get($this->itemPrimitVaca, $this->metadataPrimitVaca,1));
                    $event->setCancelled();
                    $form = [
                        'type' => 'custom_form',
                        'title' => trim($this->titleMuls),
                        'content' => [
                            [
                                "type" => "label",
                                "text" => trim($this->mesajMuls)
                            ],
                        ]
                    ];
                    $this->createWindow($damager, $form, 5);
                    return true;
                } else if (mt_rand(0, 100) > $laSuta) {
                    $inventory->remove($itemHand);
                    $event->setCancelled();
                    $form = [
                        'type' => 'custom_form',
                        'title' => trim($this->titleNereusitaMuls),
                        'content' => [
                            [
                                "type" => "label",
                                "text" => trim($this->mesajNereusitaMuls)
                            ],
                        ]
                    ];
                    $this->createWindow($damager, $form, 6);
                    return true;
                }
            }
            if ($entity instanceof Villager) {
                $form = [
                    'type' => 'form',
                    'title' => trim($this->numeVillagerMenu),
                    'content' => trim($this->mesajVillagerMenu),
                    'buttons' => [
                        ['text' => trim($this->optiuneVillagerMenu),
                        ]
                    ]
                ];
                $this->createWindow($damager, $form, 0);
                $event->setCancelled();
                return true;
            }
        }
        return true;
    }

    /**
     * @param DataPacketReceiveEvent $event
     */
    public function onReceivePacket(DataPacketReceiveEvent $event) : void{
        /** @var Player $player */
        $player = $event->getPlayer();
        /** @var PacketPool $pk */
        $pk = $event->getPacket();
        /** @var PlayerInventory $inventory */
        $inventory = $player->getInventory();
        /** @var Item $item */
        $item = Item::get(325, 1, 1);
        if ($pk instanceof ModalFormResponsePacket) {
            $formId = $pk->formId;
            $formData = trim($pk->formData);
            switch ($formId) {
                case 0:
                    switch ($formData) {
                        case null:
                        case NULL:
                        case "null":
                        case "NULL":
                            return;
                            break;
                        case 0:
                            $form = [
                                "type" => "modal",
                                "title" => trim($this->titleMuls),
                                "content" => trim($this->mesajSatean),
                                "button1" => trim($this->buttonMessageOne),
                                "button2" => trim($this->buttonMessageTwo)
                            ];
                            $this->createWindow($player, $form, 1);
                            return;
                            break;
                        default:
                            break;
                    }
                    break;
                case 1:
                    // I know that's not good, but not work if i case "False" , he don't "watch" code. That's a hacky method for fix.
                    if ($formData === false || $formData == false || $formData == "false" || $formData === "false") {
                        $form = [
                            'type' => 'custom_form',
                            'title' => trim($this->titleAnulareSchimbCuSatean),
                            'content' => [
                                [
                                    "type" => "label",
                                    "text" => trim($this->mesajAnulareSchimbCuSatean)
                                ],
                            ]
                        ];
                        $this->createWindow($player, $form, 4);
                        return;
                    }
                    switch ($formData) {
                        case null:
                        case NULL:
                        case "null":
                        case "NULL":
                            return;
                            break;
                        case "true":
                        case true:
                            if ($inventory->contains($item)) {
                                $inventory->remove($item);
                                EconomyAPI::getInstance()->addMoney($player, $this->baniDeMuls * 1);
                                $form = [
                                    'type' => 'custom_form',
                                    'title' => trim($this->titlePrimestiBaniSatean),
                                    'content' => [
                                        [
                                            "type" => "label",
                                            "text" => trim($this->mesajPrimestiBaniSatean)
                                        ],
                                    ]
                                ];
                                $this->createWindow($player, $form, 2);
                                return;
                                break;
                            } else if (!$inventory->contains($item)) {
                                $form = [
                                    'type' => 'custom_form',
                                    'title' => trim($this->titleNuAreGaleata),
                                    'content' => [
                                        [
                                            "type" => "label",
                                            "text" => trim($this->mesajNuAreGaleata)
                                        ],
                                    ]
                                ];
                                $this->createWindow($player, $form, 3);
                                return;
                                break;
                            }
                            // I know that's not good, but not work if i case "False" , he don't "watch" code. That's a hacky method for fix.
                            if ($formData === false || $formData == false || $formData == "false" || $formData === "false") {
                                $form = [
                                    'type' => 'custom_form',
                                    'title' => trim($this->titleAnulareSchimbCuSatean),
                                    'content' => [
                                        [
                                            "type" => "label",
                                            "text" => trim($this->mesajAnulareSchimbCuSatean)
                                        ],
                                    ]
                                ];
                                $this->createWindow($player, $form, 4);
                                return;
                            }
                            break;
                        default:
                            break;
                    }
                    break;
                case 2:
                    switch ($formData) {
                        case null:
                        case NULL:
                        case "null":
                        case "NULL":
                            return;
                            break;
                        default:
                            break;
                    }
                    break;
                case 3:
                    switch ($formData) {
                        case null:
                        case NULL:
                        case "null":
                        case "NULL":
                            return;
                            break;
                        default:
                            break;
                    }
                    break;
                case 4:
                    switch ($formData) {
                        case null:
                        case NULL:
                        case "null":
                        case "NULL":
                            return;
                            break;
                        default:
                            break;
                    }
                    break;
                case 5:
                    switch ($formData) {
                        case null:
                        case NULL:
                        case "null":
                        case "NULL":
                            return;
                            break;
                        default:
                            break;
                    }
                    break;
                case 6:
                    switch ($formData) {
                        case null:
                        case NULL:
                        case "null":
                        case "NULL":
                            return;
                            break;
                        default:
                            break;
                    }
                    break;
            }
        }
    }

    /**
     * @param Player $player
     * @param array $data
     * @param int $id
     */
    public function createWindow(Player $player, array $data, int $id) : void{
        $pk = new ModalFormRequestPacket();
        $pk->formId = $id;
        $pk->formData = json_encode($data, JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING | JSON_UNESCAPED_UNICODE);
        $player->dataPacket($pk);
    }
}
