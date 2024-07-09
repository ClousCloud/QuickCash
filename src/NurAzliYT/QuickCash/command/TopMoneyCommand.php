<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class TopMoneyCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("topmoney", "Shows server's top money", "/topmoney");
        $this->setPermission("quickcash.command.topmoney");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        $topPlayers = $this->plugin->getPlayerData()->getTopPlayers();
        $sender->sendMessage("Top Money Players:");
        foreach ($topPlayers as $player => $money) {
            $sender->sendMessage($player . ": $" . $money);
        }
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
