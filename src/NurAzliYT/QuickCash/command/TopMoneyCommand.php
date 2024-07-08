<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class TopMoneyCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    public function __construct(Main $plugin) {
        $this->owningPlugin = $plugin;
        parent::__construct("topmoney", "Shows server's top money", "/topmoney <page>");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        $page = 1;
        if(count($args) > 0 && is_numeric($args[0])) {
            $page = intval($args[0]);
        }

        $topMoney = $this->owningPlugin->getPlayerData()->getTopMoney($page);
        $sender->sendMessage("Top Money List (Page " . $page . "):");
        foreach($topMoney as $player => $money) {
            $sender->sendMessage($player . ": $" . $money);
        }
        return true;
    }
}
