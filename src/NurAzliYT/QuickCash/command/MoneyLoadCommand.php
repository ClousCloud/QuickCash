<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class MoneyLoadCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("moneyload", "Loads data from your hardware", "/moneyload", ["moneyload"]);
        $this->setPermission("quickcash.command.moneyload");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        $this->plugin->getPlayerData()->load();
        $sender->sendMessage("Data has been loaded.");
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
