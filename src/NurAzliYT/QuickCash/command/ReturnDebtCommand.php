<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\player\Player;
use NurAzliYT\QuickCash\Main;

class ReturnDebtCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    public function __construct(Main $plugin) {
        $this->owningPlugin = $plugin;
        parent::__construct("returndebt", "Returns money to the plugin", "/returndebt <money>");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender instanceof Player) {
            if(count($args) !== 1 || !is_numeric($args[0])) {
                $sender->sendMessage("Usage: /returndebt <money>");
                return false;
            }

            $amount = floatval($args[0]);
            $this->owningPlugin->getPlayerData()->reduceDebt($sender->getName(), $amount);
            $sender->sendMessage("You have returned $" . $amount . ".");
        } else {
            $sender->sendMessage("This command can only be used by players.");
        }
        return true;
    }
}
