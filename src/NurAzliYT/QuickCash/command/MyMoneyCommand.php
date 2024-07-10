<?php

declare(strict_types=1);

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\player\Player;
use NurAzliYT\QuickCash\Main;

class MyMoneyCommand extends PluginCommand implements PluginOwned {
    use PluginOwnedTrait;

    public function __construct(Main $plugin) {
        parent::__construct("mymoney", $plugin);
        $this->setDescription("Shows your money");
        $this->setPermission("quickcash.command.mymoney");
        $this->owningPlugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if ($sender instanceof Player) {
            $money = $this->owningPlugin->getPlayerData()->getMoney($sender);
            $sender->sendMessage("You have $" . $money);
            return true;
        } else {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }
    }
}
