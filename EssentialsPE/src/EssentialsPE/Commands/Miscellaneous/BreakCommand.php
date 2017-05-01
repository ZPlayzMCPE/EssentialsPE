<?php

namespace EssentialsPE\Commands\Miscellaneous;

use EssentialsPE\Commands\BaseCommand;
use EssentialsPE\Loader;
use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class BreakCommand extends BaseCommand {

	public function __construct(Loader $loader) {
		parent::__construct($loader, "break", "Breaks the block you're looking at");
		$this->setPermission("essentials.command.break.use");
		$this->setModule(Loader::MODULE_ESSENTIALS);
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $alias
	 * @param array         $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, $alias, array $args): bool {
		if(!$this->testPermission($sender)) {
			$this->sendPermissionMessage($sender);
			return false;
		}
		if(!$sender instanceof Player) {
			$this->sendUsage($sender, $alias);
			return false;
		}
		if(($block = $sender->getTargetBlock(100, [Block::AIR])) === null) {
			$sender->sendMessage(TextFormat::RED . "[Error] " . $this->getMessages()->getMessages()["command"]["error"]["break"]["no-target"]);
			return false;
		} elseif($block->getId() === Block::BEDROCK && !$sender->hasPermission("essentials.command.break.bedrock")) {
			$sender->sendMessage(TextFormat::RED . "[Error] " . $this->getMessages()->getMessages()["command"]["error"]["break"]["bedrock-perm"]);
			return false;
		}
		$sender->getLevel()->setBlock($block, new Air(), true, true);
		return true;
	}
}