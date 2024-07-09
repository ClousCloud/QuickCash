<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\player\Player;
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

class Main extends PluginBase {

    private Config $playerData;

    public function onEnable(): void {
        
        $this->playerData = new Config($this->getDataFolder() . "playerData.json", Config::JSON, []);

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

    public function onDisable(): void {
        $this->playerData->save();
    }

    private function registerCommand(Command $command): void {
        $this->getServer()->getCommandMap()->register("quickcash", $command);
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
