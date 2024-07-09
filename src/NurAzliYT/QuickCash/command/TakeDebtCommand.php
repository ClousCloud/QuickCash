<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\player\Player;
use NurAzliYT\QuickCash\Main;

class TakeDebtCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->owningPlugin = $plugin;
        parent::__construct("takedebt", "Borrows money from plugin", "/takedebt <money>");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender instanceof Player) {
            if(count($args) !== 1 || !is_numeric($args[0])) {
                $sender->sendMessage("Usage: /takedebt <money>");
                return false;
            }

            $amount = floatval($args[0]);
            $this->plugin->addDebt($sender->getName(), $amount);
            $this->plugin->addMoney($sender->getName(), $amount);
            $sender->sendMessage("Borrowed $" . $amount . " from the plugin.");
        } else {
            $sender->sendMessage("This command can only be used in-game.");
        }
        return true;
    }
}
