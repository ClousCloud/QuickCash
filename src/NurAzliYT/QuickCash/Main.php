<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\command\PluginCommand;
use NurAzliYT\QuickCash\command\{
    MyMoneyCommand, MyDebtCommand, TakeDebtCommand, ReturnDebtCommand, 
    TopMoneyCommand, MoneySaveCommand, MoneyLoadCommand, SetMoneyCommand, 
    GiveMoneyCommand, TakeMoneyCommand, SeeMoneyCommand
};

class Main extends PluginBase {

    /** @var PlayerData */
    private $playerData;

    public function onEnable(): void {
        @mkdir($this->getDataFolder());
        $this->playerData = new PlayerData($this);

        $this->registerCommands();
    }

    public function onDisable() {
        //Empty or Coming Soon
    }

    private function registerCommands() {
        $this->getServer()->getCommandMap()->registerAll("quickcash", [
            new PluginCommand("mymoney", $this, new MyMoneyCommand($this)),
            new PluginCommand("mydebt", $this, new MyDebtCommand($this)),
            new PluginCommand("takedebt", $this, new TakeDebtCommand($this)),
            new PluginCommand("returndebt", $this, new ReturnDebtCommand($this)),
            new PluginCommand("topmoney", $this, new TopMoneyCommand($this)),
            new PluginCommand("moneysave", $this, new MoneySaveCommand($this)),
            new PluginCommand("moneyload", $this, new MoneyLoadCommand($this)),
            new PluginCommand("setmoney", $this, new SetMoneyCommand($this)),
            new PluginCommand("givemoney", $this, new GiveMoneyCommand($this)),
            new PluginCommand("takemoney", $this, new TakeMoneyCommand($this)),
            new PluginCommand("seemoney", $this, new SeeMoneyCommand($this)),
        ]);
    }

    public function getPlayerData(): PlayerData {
        return $this->playerData;
    }
}
