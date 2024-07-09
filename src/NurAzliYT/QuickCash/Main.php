<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\player\Player;
use pocketmine\command\CommandExecutor;

class Main extends PluginBase {

    private Config $playerData;

    public function onEnable(): void {
        $this->getLogger()->info("QuickCash plugin enabled.");
        
        $this->playerData = new Config($this->getDataFolder() . "playerData.json", Config::JSON, []);

        $this->registerCommand("mymoney", new MyMoneyCommand($this));
        $this->registerCommand("mydebt", new MyDebtCommand($this));
        $this->registerCommand("takedebt", new TakeDebtCommand($this));
        $this->registerCommand("returndebt", new ReturnDebtCommand($this));
        $this->registerCommand("topmoney", new TopMoneyCommand($this));
        $this->registerCommand("moneysave", new MoneySaveCommand($this));
        $this->registerCommand("moneyload", new MoneyLoadCommand($this));
        $this->registerCommand("setmoney", new SetMoneyCommand($this));
        $this->registerCommand("givemoney", new GiveMoneyCommand($this));
        $this->registerCommand("takemoney", new TakeMoneyCommand($this));
        $this->registerCommand("seemoney", new SeeMoneyCommand($this));
    }

    public function onDisable(): void {
        $this->getLogger()->info("QuickCash plugin disabled.");
        $this->playerData->save();
    }

    private function registerCommand(string $name, CommandExecutor $executor): void {
        $command = $this->getServer()->getCommandMap()->getCommand($name);
        if ($command !== null) {
            $command->setExecutor($executor);
        }
    }

    public function getPlayerData(): Config {
        return $this->playerData;
    }

    public function getMoney(string $player): float {
        return $this->playerData->getNested($player . ".money", 0.0);
    }

    public function setMoney(string $player, float $amount): void {
        $this->playerData->setNested($player . ".money", $amount);
        $this->playerData->save();
    }

    public function addMoney(string $player, float $amount): void {
        $money = $this->getMoney($player);
        $this->setMoney($player, $money + $amount);
    }

    public function reduceMoney(string $player, float $amount): void {
        $money = $this->getMoney($player);
        $this->setMoney($player, max($money - $amount, 0));
    }

    public function getDebt(string $player): float {
        return $this->playerData->getNested($player . ".debt", 0.0);
    }

    public function addDebt(string $player, float $amount): void {
        $debt = $this->getDebt($player);
        $this->playerData->setNested($player . ".debt", $debt + $amount);
        $this->playerData->save();
    }

    public function reduceDebt(string $player, float $amount): void {
        $debt = $this->getDebt($player);
        $this->playerData->setNested($player . ".debt", max($debt - $amount, 0));
        $this->playerData->save();
    }

    public function getTopMoney(int $page = 1, int $pageSize = 10): array {
        $allData = $this->playerData->getAll();
        uasort($allData, fn($a, $b) => $b["money"] <=> $a["money"]);

        return array_slice($allData, ($page - 1) * $pageSize, $pageSize, true);
    }
}
