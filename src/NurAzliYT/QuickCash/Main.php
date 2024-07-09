<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use NurAzliYT\QuickCash\command\{
    MyMoneyCommand,
    MyDebtCommand,
    TakeDebtCommand,
    ReturnDebtCommand,
    TopMoneyCommand,
    MoneySaveCommand,
    MoneyLoadCommand,
    SetMoneyCommand,
    GiveMoneyCommand,
    TakeMoneyCommand,
    SeeMoneyCommand
};
use NurAzliYT\QuickCash\data\PlayerData;

class Main extends PluginBase {
    private PlayerData $playerData;

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->playerData = new PlayerData($this);

        $this->registerCommand(new MyMoneyCommand($this));
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
        $this->getServer()->getCommandMap()->register($command->getName(), $command);
    }

    public function getPlayerData(): PlayerData {
        return $this->playerData;
    }
}
