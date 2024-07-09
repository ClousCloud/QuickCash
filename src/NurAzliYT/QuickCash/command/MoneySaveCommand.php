<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class MoneySaveCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->owningPlugin = $plugin;
        parent::__construct("moneysave", "Saves data to your hardware", "/moneysave");
        $this->setPermission("quickcash.console");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender->hasPermission("quickcash.console")) {
            $this->plugin->getPlayerData()->save();
            $sender->sendMessage("Player data saved to hardware.");
        } else {
            $sender->sendMessage("You don't have permission to use this command.");
        }
        return true;
    }
}
