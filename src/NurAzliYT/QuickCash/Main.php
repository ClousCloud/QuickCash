<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
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
    private $playerData;

    public function onEnable(): void {
        $this->playerData = new PlayerData($this);

        $this->getServer()->getCommandMap()->registerAll("quickcash", [
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
