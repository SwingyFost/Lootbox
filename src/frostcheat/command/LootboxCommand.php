<?php

namespace frostcheat\command;

use frostcheat\Main;
use frostcheat\item\LootBox;
use frostcheat\backup\ItemsBackup;
use frostcheat\Utils;

use frostcheat\modules\Lutbocs as PartnerPackage;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as TE;
use pocketmine\player\Player;
use pocketmine\block\VanillaBlocks;
use pocketmine\nbt\tag\StringTag;

class LootboxCommand extends Command
{

    /**
     * ParterPackagesCommand constructor.
     */
    public function __construct()
    {
        parent::__construct("lootbox");
        $this->setPermission("lootbox.command");
    }

    /**
     * @param CommandSender $sender
     * @param string $label
     * @param array $args
     */
    public function execute(CommandSender $sender, string $label, array $args): void
    {
        if (count($args) === 0) {
            $sender->sendMessage(TE::RED . "/lootbox give player|all {amount}");
            return;
        }
        switch ($args[0]) {
            case "setitems":
                if (!$sender->getServer()->isOp($sender->getName())) {
                    $sender->sendMessage(TE::RED . "You don't have permissions");
                    return;
                }
                if (!$sender instanceof Player) {
                    $sender->sendMessage(TE::RED . "This message can only be executed in game!");
                    return;
                }
                $player = Main::getInstance()->getServer()->getPlayerByPrefix($sender->getName());
                Main::$rewards = new PartnerPackage($player->getInventory()->getContents());
                $sender->sendMessage(TE::GREEN . "Items Edited Sucesfully");
                
                break;
                
            case "give":
                if (!$sender->getServer()->isOp($sender->getName())) {
                    $sender->sendMessage(TE::RED . "NoPermission");
                    return;
                }
                if (empty($args[1])) {
                    $sender->sendMessage(TE::RED . "/lootbox give player|all {amount}");
                    return;
                }
                if (empty($args[2])) {
                    $sender->sendMessage(TE::RED . "/lootbox give player|all {amount}");
                    return;
                }
                $player = Main::getInstance()->getServer()->getPlayerByPrefix($args[1]);
                if ($player !== null) {
                    $this->addPartner($player, $args[2]);
                    return;
                }
                foreach (Main::getInstance()->getServer()->getOnlinePlayers() as $player) {
                    $this->addPartner($player, $args[2]);
                }
                break;
        }
    }
    
    public function addPartner(Player $player, int $int){
        $pp = VanillaBlocks::BEACON();
        $item = $pp->asItem(); // Convertir a item regular
        $item->setCustomName(TE::colorize("&l&bLootBox"));
        $namedtag = $item->getNamedTag();
        $namedtag->setString('LootBox', "LootBox");
        $item->setNamedTag($namedtag);
        $item->setCount($int);
        $player->getInventory()->addItem($item);
    }
}