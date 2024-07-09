<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class MyMoneyCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("mymoney", "Shows your money", "/mymoney", ["mymoney"]);
        $this->setPermission("quickcash.command.mymoney");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        $money = $this->plugin->getPlayerData()->getMoney($sender->getName());
        $sender->sendMessage("You have $" . $money);
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
