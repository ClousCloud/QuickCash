<?php

declare(strict_types=1);

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\PluginCommand;
use NurAzliYT\QuickCash\data\PlayerData;
use NurAzliYT\QuickCash\command\MyMoneyCommand;
use NurAzliYT\QuickCash\command\MyDebtCommand;
use NurAzliYT\QuickCash\command\TakeDebtCommand;
use NurAzliYT\QuickCash\command\ReturnDebtCommand;
use NurAzliYT\QuickCash\command\TopMoneyCommand;
use NurAzliYT\QuickCash\command\MoneySaveCommand;
use NurAzliYT\QuickCash\command\MoneyLoadCommand;
use NurAzliYT\QuickCash\command\SetMoneyCommand;
use NurAzliYT\QuickCash\command\GiveMoneyCommand;
use NurAzliYT\QuickCash\command\TakeMoneyCommand;
use NurAzliYT\QuickCash\command\SeeMoneyCommand;

class Main extends PluginBase {

    private PlayerData $playerData;

    public function onEnable(): void {
        $this->playerData = new PlayerData($this);

        $this->registerCommand(new MyMoneyCommand($this));
        $this->registerCommand(new MyDebtCommand($this));
        $this->registerCommand(new TakeDebtCommand($this));
        $this->registerCommand(new ReturnDebtCommand($this));
        $this->registerCommand(new TopMoneyCommand($this));
        $this->registerCommand(new MoneySaveCommand($this));
        $this->registerCommand(new MoneyLoadCommand($this));
        $this->registerCommand(new SetMoneyCommand($this));
        $this->registerCommand(new GiveMoneyCommand($this));
        $this->registerCommand(new TakeMoneyCommand($this));
        $this->registerCommand(new SeeMoneyCommand($this));
    }

    private function registerCommand(Command $command): void {
        if ($command instanceof PluginCommand) {
            $command->setPermissionMessage("You do not have permission to use this command");
        }
        $this->getServer()->getCommandMap()->register($this->getName(), $command);
    }

    public function getPlayerData(): PlayerData {
        return $this->playerData;
    }
}
