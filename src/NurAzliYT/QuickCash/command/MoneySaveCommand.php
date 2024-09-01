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
        parent::__construct("moneysave", "Saves data to your hardware", "/moneysave");
        $this->setPermission("quickcash.command.moneysave");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        $this->plugin->getPlayerData()->save();
        $sender->sendMessage("Data has been saved.");
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
