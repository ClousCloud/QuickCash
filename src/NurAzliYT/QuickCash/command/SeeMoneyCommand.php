<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class SeeMoneyCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("seemoney", "Shows a player's money", "/seemoney <player>", ["seemoney"]);
        $this->setPermission("quickcash.command.seemoney");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 1) {
            $sender->sendMessage("Usage: /seemoney <player>");
            return false;
        }

        $player = $args[0];
        $money = $this->plugin->getPlayerData()->getMoney($player);
        $sender->sendMessage("$player has $$money");
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
