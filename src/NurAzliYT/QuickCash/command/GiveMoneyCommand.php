<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class GiveMoneyCommand extends PluginCommand implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("givemoney", "Gives money to a player", "/givemoney <player> <money>", ["givemoney"]);
        $this->setPermission("quickcash.command.givemoney");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 2 || !is_numeric($args[1])) {
            $sender->sendMessage("Usage: /givemoney <player> <money>");
            return false;
        }

        $player = $args[0];
        $amount = (int)$args[1];
        $this->plugin->getPlayerData()->addMoney($player, $amount);
        $sender->sendMessage("Gave $$amount to $player");
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
