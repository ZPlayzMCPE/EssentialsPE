<?php
namespace EssentialsPE\Commands\Teleport;

use EssentialsPE\BaseFiles\BaseAPI;
use EssentialsPE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class TPHere extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "tphere", "Teleport a player to you", "<player>", false, ["s"]);
        $this->setPermission("essentials.tphere");
    }

    /**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, $alias, array $args) {
        if(!$this->testPermission($sender)){
            return false;
        }
        if(!$sender instanceof Player || count($args) !== 1){
            $this->sendUsage($sender, $alias);
            return false;
        }
        if(!($player = $this->getAPI()->getPlayer($args[0]))){
            $sender->sendMessage(TextFormat::RED . "[Error] §6This player cannot be found.");
            return false;
        }
        $player->teleport($sender);
        $player->sendMessage(TextFormat::YELLOW . "§bTeleporting to§3 " . $sender->getDisplayName() . "...");
        $sender->sendMessage(TextFormat::YELLOW . "§bTeleporting§3 " . $player->getDisplayName() . " §bto you...");
        return true;
    }
} 
