<?php

namespace frostcheat;

use frostcheat\backup\ItemsBackup;
use frostcheat\item\LootboxListener;
use frostcheat\item\LootBox;
use frostcheat\item\LootBoxSerializer;
use frostcheat\command\LootboxCommand;
use pocketmine\data\bedrock\item\ItemSerializer; 

use muqsit\invmenu\InvMenuHandler;

use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TE;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper as Helper;
use pocketmine\entity\EntityFactory;
use pocketmine\data\bedrock\EntityLegacyIds as LegacyIds;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\entity\Zombie;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\World;

class Main extends PluginBase {
    
    use SingletonTrait;
    
    public static $rewards;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }
    public function onEnable(): void {
        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }
        
        $this->registerCommand(new LootboxCommand());
        
        $this->getServer()->getPluginManager()->registerEvents(new LootboxListener($this), $this);
        if(!is_dir($this->getDataFolder()."backup")){
        	@mkdir($this->getDataFolder()."backup");
        }
        ItemsBackup::init();
    }
    
    public function onDisable(): void {
        ItemsBackup::save();
    }
    
    public static function getInstance(): Main {
        return self::$instance;
    }

    public function registerCommand(Command ...$commands) : void {
        foreach($commands as $command){
            $this->getServer()->getCommandMap()->register("hcf", $command);
        }
    }


}

