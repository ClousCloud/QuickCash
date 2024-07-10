<?php

declare(strict_types=1);

namespace NurAzliYT\QuickCash\command;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use pocketmine\player\Player;
use NurAzliYT\QuickCash\Main;

class GiveMoneyCommand extends PluginCommand implements PluginOwned {
    use PluginOwnedTrait;

    public function __construct(Main $plugin) {
        parent::__construct("givemoney", $plugin);
        $this->setDescription("Gives money to a player");
        $this->setPermission("quickcash.command.givemoney");
        $this->owningPlugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) < 2 || !is_numeric($args[1])) {
            $sender->sendMessage("Usage: /givemoney <player> <money>");
            return false;
        }

        $playerName = $args[0];
        $amount = (int) $args[1];
        $player = $this->owningPlugin->getServer()->getPlayerByPrefix($playerName);

        if ($player instanceof Player) {
            $this->owningPlugin->getPlayerData()->addMoney($player, $amount);
            $sender->sendMessage("Gave $" . $amount . " to " . $player->getName());
            $player->sendMessage("You have received $" . $amount);
            return true;
        } else {
            $sender->sendMessage("Player not found.");
            return false;
        }
    }
}
