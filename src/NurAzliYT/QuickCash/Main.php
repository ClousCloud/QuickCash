<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\SimpleCommandMap;
use pocketmine\utils\Config;
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

    /** @var Config */
    private $playerData;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->playerData = new Config($this->getDataFolder() . "PlayerData.yml", Config::YAML, [
            'default_money' => $this->getConfig()->get('default_money', 1000)
        ]);

        $this->registerCommands();
    }

    private function registerCommands(): void {
        $commandMap = $this->getServer()->getCommandMap();
        
        $commands = [
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
        ];

        foreach ($commands as $command) {
            $commandMap->register($command->getName(), $command);
        }
    }

    public function getPlayerData(): Config {
        return $this->playerData;
    }

    public function onDisable(): void {
        $this->playerData->save();
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
