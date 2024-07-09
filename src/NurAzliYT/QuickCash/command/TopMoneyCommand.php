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
        $this->plugin = $plugin;
        $this->owningPlugin = $plugin;
        parent::__construct("topmoney", "Shows server's top money", "/topmoney <page>");
        $this->setPermission("quickcash.command.topmoney");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        $page = isset($args[0]) && is_numeric($args[0]) ? intval($args[0]) : 1;
        $topMoney = $this->plugin->getTopMoney($page);

        $sender->sendMessage("Top money players (Page $page):");
        foreach ($topMoney as $player => $data) {
            $sender->sendMessage($player . ": $" . $data['money']);
        }
        return true;
    }
}
