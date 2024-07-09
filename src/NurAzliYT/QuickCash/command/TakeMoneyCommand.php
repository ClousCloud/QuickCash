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
        $this->plugin = $plugin;
        $this->owningPlugin = $plugin;
        parent::__construct("takemoney", "Takes money from a player", "/takemoney <player> <money>");
        $this->setPermission("quickcash.admin");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender->hasPermission("quickcash.admin")) {
            if(count($args) !== 2 || !is_numeric($args[1])) {
                $sender->sendMessage("Usage: /takemoney <player> <money>");
                return false;
            }

            $player = $args[0];
            $amount = floatval($args[1]);
            $this->plugin->reduceMoney($player, $amount);
            $sender->sendMessage("Took $" . $amount . " from " . $player . ".");
        } else {
            $sender->sendMessage("You don't have permission to use this command.");
        }
        return true;
    }
}
