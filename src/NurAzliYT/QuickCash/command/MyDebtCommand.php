<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\player\Player;
use NurAzliYT\QuickCash\Main;

class MyDebtCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    public function __construct(Main $plugin) {
        $this->owningPlugin = $plugin;
        parent::__construct("mydebt", "Shows your debt", "/mydebt");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender instanceof Player) {
            $debt = $this->owningPlugin->getPlayerData()->getDebt($sender->getName());
            $sender->sendMessage("Your debt: $" . $debt);
        } else {
            $sender->sendMessage("This command can only be used by players.");
        }
        return true;
    }
}
