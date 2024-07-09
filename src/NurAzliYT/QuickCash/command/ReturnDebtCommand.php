<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class ReturnDebtCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("returndebt", "Returns money to the plugin", "/returndebt <money>");
        $this->setPermission("quickcash.command.returndebt");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        if (count($args) !== 1 || !is_numeric($args[0])) {
            $sender->sendMessage("Usage: /returndebt <money>");
            return false;
        }

        $amount = (int)$args[0];
        $this->plugin->getPlayerData()->takeDebt($sender->getName(), $amount);
        $sender->sendMessage("You have returned $" . $amount);
        return true;
    }

    public function getOwningPlugin(): Main {
        return $this->plugin;
    }
}
