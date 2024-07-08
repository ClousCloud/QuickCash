<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class MoneySaveCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    public function __construct(Main $plugin) {
        $this->owningPlugin = $plugin;
        parent::__construct("moneysave", "Saves data to your hardware", "/moneysave");
        $this->setPermission("quickcash.admin");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender->hasPermission("quickcash.admin")) {
            $this->owningPlugin->getPlayerData()->save();
            $sender->sendMessage("Player data has been saved.");
        } else {
            $sender->sendMessage("You don't have permission to use this command.");
        }
        return true;
    }
}
