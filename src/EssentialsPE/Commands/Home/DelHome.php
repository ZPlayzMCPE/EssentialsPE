<?php
namespace EssentialsPE\Commands\Home;

use EssentialsPE\BaseFiles\BaseAPI;
use EssentialsPE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class DelHome extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "delhome", "Remove a home", "<name>", false, ["remhome", "removehome"]);
        $this->setPermission("essentials.delhome");
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
        if(!$this->getAPI()->homeExists($sender, $args[0])){
            $sender->sendMessage(TextFormat::RED . "[Error] §6This Home doesn't exist");
            return false;
        }
        $this->getAPI()->removeHome($sender, $args[0]);
        $sender->sendMessage(TextFormat::GREEN . "§bThe home you entered has been successfully removed / deleted!");
        return true;
    }
} 
