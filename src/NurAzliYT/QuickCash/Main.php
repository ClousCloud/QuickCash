<?php

declare(strict_types=1);

namespace NurAzliYT\QuickCash;

use pocketmine\command\CommandMap;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use NurAzliYT\QuickCash\data\PlayerData;
use NurAzliYT\QuickCash\command\{
    MyMoneyCommand, MyDebtCommand, TakeDebtCommand, ReturnDebtCommand, 
    TopMoneyCommand, MoneySaveCommand, MoneyLoadCommand, 
    SetMoneyCommand, GiveMoneyCommand, TakeMoneyCommand, SeeMoneyCommand
};

class Main extends PluginBase {

    private PlayerData $playerData;

    public function onEnable(): void {
        $this->playerData = new PlayerData($this);

        $this->getServer()->getCommandMap()->registerAll(null, [
            new MyMoneyCommand($this),
            new MyDebtCommand($this),
            new TakeDebtCommand($this),
            new ReturnDebtCommand($this),
            new TopMoneyCommand($this),
            new MoneySaveCommand($this),
            new MoneyLoadCommand($this),
            new SetMoneyCommand($this),
            new GiveMoneyCommand($this),
            new TakeMoneyCommand($this),
            new SeeMoneyCommand($this)
        ]);
    }

    public function getPlayerData(): PlayerData {
        return $this->playerData;
    }
}
