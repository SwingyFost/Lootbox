<?php

namespace frostcheat\item;

use frostcheat\Main;
use frostcheat\item\LootBox;
use frostcheat\item\task\LootboxTask;
use frostcheat\backup\ItemsBackup;
use frostcheat\modules\Lutbocs as PartnerPackage;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\inventory\InvMenuInventory;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;

use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\world\sound\DoorCrashSound;
use pocketmine\utils\TextFormat as C;
use pocketmine\block\Beacon;

/**
 * Class GreekListener
 * @package GreekHCF
 */
class LootboxListener implements Listener {
    
    public function onInteract(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
        $hand = $player->getInventory()->getItemInHand();
        if($hand->getNamedTag()->getTag("LootBox")){
            $event->cancel();
            $player->getInventory()->setItemInHand($player->getInventory()->getItemInHand()->setCount($player->getInventory()->getItemInHand()->getCount() - 1));
            $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
            $inv = $menu->getInventory();
            $menu->setName(C::colorize("&r&bLootBox"));
            $menu->setListener(function(InvMenuTransaction $transaction): InvMenuTransactionResult{
                return $transaction->discard();
            });
            $menu->send($player);

            Main::getInstance()->getScheduler()->scheduleRepeatingTask(new LootboxTask($inv, $player),5);
        }
    }
}