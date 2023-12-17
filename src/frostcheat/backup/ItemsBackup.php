<?php

namespace frostcheat\backup;


use frostcheat\Main;
use frostcheat\Utils;
use frostcheat\modules\Lutbocs as PartnerPackage;
use pocketmine\utils\Config;

class ItemsBackup {

    public static function init() : void {
        $rewards = [];

        $data = new Config(Main::getInstance()->getDataFolder()."backup".DIRECTORY_SEPARATOR."rewards.yml", Config::YAML);
        foreach($data->getAll() as $rewardBackup){
            $result = $data->getAll();
            if(isset($result["items"])){
                foreach($result["items"] as $number => $reward){
                    $rewards[$number] = Utils::itemDeserialize($reward);
                    Main::$rewards = new PartnerPackage($rewards);
                }
            }
        }
    }

    public static function save() : void {
        $rewardData = [];
        $result = new Config(Main::getInstance()->getDataFolder()."backup".DIRECTORY_SEPARATOR."rewards.yml", Config::YAML);
            foreach(PartnerPackage::getItems() as $number => $reward){
                $rewardData[$number] = Utils::itemSerialize($reward);
            }
        $result->set("items", $rewardData);
        $result->save();
    }

}

?>