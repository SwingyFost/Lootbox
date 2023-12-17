<?php

namespace frostcheat\modules;

use frostcheat\Main;
use frostcheat\Utils;

use pocketmine\utils\Config;
use pocketmine\item\Item;

/**
 * Class PartnerPackage
 * @package GreekHCF\modules
 */
class Lutbocs
{

    /** @var array|null */
    public static $rewards = [];

    /**
     * PartnerPackage constructor.
     * @param array|null $rewards
     */
    public function __construct(?array $rewards = [])
    {
        self::$rewards = $rewards;
        $rewardData = [];
        $file = new Config(Main::getInstance()->getDataFolder() . "backup" . DIRECTORY_SEPARATOR . "rewards.yml", Config::YAML);
        foreach (self::getItems() as $slot => $reward) {
            $rewardData[$slot] = Utils::itemSerialize($reward);
        }
        $file->set("items", $rewardData);
        $file->save();
    }

    /**
     * @return array
     */
    public static function getItems(): array
    {
        return self::$rewards;
    }

    public static function getRandomItem(): Item
    {
        return self::$rewards[array_rand(self::$rewards)];
    }
}