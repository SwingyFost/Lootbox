<?php

namespace frostcheat\item;

use frostcheat\item\Listener;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\TextFormat as C;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\Taggable;

class LootBox extends Listener implements Taggable
{

    public function __construct()
    {
        $c = C::RESET.C::BOLD.C::AQUA;
        parent::__construct(new ItemIdentifier(10030, 0), $c."LootBox", [C::colorize(
            "\n&r&7Right click to open\n".
            "\n".
            "&r&eAvaiable at &baquamc.tebex.io\n"
        )]);
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }
    
    public function encodeNBT(): CompoundTag {
        return (new LootBoxSerializer())->serialize($this);
    }

    public static function decodeNBT(CompoundTag $tag): LootBox {
        return (new LootBoxSerializer())->deserialize($tag);
    }
}