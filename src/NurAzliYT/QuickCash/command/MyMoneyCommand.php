<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\player\Player;
use NurAzliYT\QuickCash\Main;

class MyMoneyCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->owningPlugin = $plugin;
        parent::__construct("mymoney", "Shows your money", "/mymoney");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender instanceof Player) {
            $money = $this->plugin->getMoney($sender->getName());
            $sender->sendMessage("Your current balance: $" . $money);
        } else {
            $sender->sendMessage("This command can only be used in-game.");
        }
        return true;
    }
}
