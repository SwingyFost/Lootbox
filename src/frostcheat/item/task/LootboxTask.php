<?php

namespace frostcheat\item\task;

use frostcheat\Main;
use frostcheat\modules\Lutbocs as PartnerPackage;
use pocketmine\entity\Location;
use pocketmine\world\World;
use pocketmine\world\Position;
use pocketmine\world\sound\ClickSound;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\inventory\InvMenuInventory;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as C;

class LootboxTask extends Task{

    const HOPPER_PLACEMENT = 4;
    
    private array $cristales = [
        0, 1, 2, 3, 5, 6, 7, 8, 18, 19, 20, 21, 22, 23, 24, 25, 26
    ];

    private array $lines = [
        9,10,11,12,13,14,15,16,17
    ];
    private InvMenuInventory $inventory;
    private Player $player;
    private int $seconds = 25;

    public function __construct(InvMenuInventory|Inventory $inventory, Player $player){
        $this->inventory = $inventory;
        $this->player = $player;
    }

    public function onRun(): void{
        $this->seconds--;
        #$jopa = VanillaItems::
        $jopa = VanillaItems::COMPASS()->setCustomName(C::colorize("&r&l&bSelector!"));
        $this->inventory->setItem(self::HOPPER_PLACEMENT, $jopa);
        if($this->player === null || !$this->player->isOnline()){
            $this->getHandler()->cancel();
            return;
        }
        if($this->inventory === null){
            $this->player->sendMessage(C::RED . "You exited the inventory, the animation has been cancelled.");
            $this->getHandler()->cancel();
            return;
        }
        foreach($this->cristales as $cristales){
            $items = [
            VanillaBlocks::STAINED_GLASS()->asItem(), 
            VanillaBlocks::STAINED_GLASS()->asItem(), 
            VanillaBlocks::STAINED_GLASS()->asItem(), 
            VanillaBlocks::STAINED_GLASS()->asItem(),
            VanillaBlocks::STAINED_GLASS()->asItem(), 
            VanillaBlocks::STAINED_GLASS()->asItem()
            ];
            $item = $items[array_rand($items)];
            $this->inventory->setItem($cristales, $item);
        }
        foreach($this->lines as $line){
            $chance = mt_rand(1,9);
            $player = $this->player;
            $world = $player->getWorld();
            switch($chance){
                case 1:
                    $item = PartnerPackage::getRandomItem();
                    break;
                case 2:
                    $item = PartnerPackage::getRandomItem();
                    break;
                case 3:
                    $item = PartnerPackage::getRandomItem();
                    break;
                case 4:
                    $item = PartnerPackage::getRandomItem();
                    break;
                case 5:
                    $item = PartnerPackage::getRandomItem();
                    break;
                case 6:
                    $item = PartnerPackage::getRandomItem();
                    break;
                case 7:
                    $item = PartnerPackage::getRandomItem();
                    break;
                case 8:
                    $item = PartnerPackage::getRandomItem();
                    break;
                case 9: 
                    $item = PartnerPackage::getRandomItem();
                    break;        
            }

           
            $this->inventory->setItem($line, $item);
        }
        $bool = false;
        if($this->seconds <= 0){
                $item = $this->inventory->getItem(13);
                $this->player->sendMessage(C::colorize("&r&7[&bLootBox&7] &fYou have received &e".$item->getName()));
                $this->player->getInventory()->addItem($item);

            $this->player->removeCurrentWindow();
            $this->getHandler()->cancel();
        }
    }
}
