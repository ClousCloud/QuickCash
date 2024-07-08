<?php

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class GiveMoneyCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    public function __construct(Main $plugin) {
        $this->owningPlugin = $plugin;
        parent::__construct("givemoney", "Gives money to player", "/givemoney <player> <money>");
        $this->setPermission("quickcash.admin");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if($sender->hasPermission("quickcash.admin")) {
            if(count($args) !== 2 || !is_numeric($args[1])) {
                $sender->sendMessage("Usage: /givemoney <player> <money>");
                return false;
            }

            $player = $args[0];
            $amount = floatval($args[1]);
            $this->owningPlugin->getPlayerData()->addMoney($player, $amount);
            $sender->
