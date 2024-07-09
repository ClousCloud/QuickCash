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

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->owningPlugin = $plugin;
        parent::__construct("returndebt", "Returns debt to the plugin", "/returndebt <money>");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender instanceof Player) {
            if(count($args) !== 1 || !is_numeric($args[0])) {
                $sender->sendMessage("Usage: /returndebt <money>");
                return false;
            }

            $amount = floatval($args[0]);
            $debt = $this->plugin->getDebt($sender->getName());
            if ($debt < $amount) {
                $sender->sendMessage("You don't have that much debt.");
                return false;
            }

            $this->plugin->reduceDebt($sender->getName(), $amount);
            $this->plugin->reduceMoney($sender->getName(), $amount);
            $sender->sendMessage("Returned $" . $amount . " of your debt.");
        } else {
            $sender->sendMessage("This command can only be used in-game.");
        }
        return true;
    }
}
