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
        $this->plugin = $plugin;
        $this->owningPlugin = $plugin;
        parent::__construct("seemoney", "Shows player's money", "/seemoney <player>");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if(count($args) !== 1) {
            $sender->sendMessage("Usage: /seemoney <player>");
            return false;
        }

        $player = $args[0];
        $money = $this->plugin->getMoney($player);
        $sender->sendMessage($player . " has $" . $money . ".");
        return true;
    }
}
