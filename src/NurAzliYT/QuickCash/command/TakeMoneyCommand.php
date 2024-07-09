<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class TakeMoneyCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("takemoney", "Takes money from a player", "/takemoney <player> <money>");
        $this->setPermission("quickcash.command.takemoney");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 2 || !is_numeric($args[1])) {
            $sender->sendMessage("Usage: /takemoney <player> <money>");
            return false;
        }

        $player = $args[0];
        $amount = (int)$args[1];
        $this->plugin->getPlayerData()->takeMoney($player, $amount);
        $sender->sendMessage("Took $$amount from $player");
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
