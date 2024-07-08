<?php

namespace NurAzliYT\QuickCash;

use pocketmine\utils\Config;

class PlayerData {

    /** @var Config */
    private $config;
    private $debts;

    public function __construct(Main $plugin) {
        $this->config = new Config($plugin->getDataFolder() . "playerdata.yml", Config::YAML);
        $this->debts = new Config($plugin->getDataFolder() . "debts.yml", Config::YAML);
    }

    public function getMoney(string $player): float {
        return $this->config->get($player, 0);
    }

    public function addMoney(string $player, float $amount) {
        $currentMoney = $this->getMoney($player);
        $newMoney = $currentMoney + $amount;
        $this->config->set($player, $newMoney);
        $this->config->save();
    }

    public function setMoney(string $player, float $amount) {
        $this->config->set($player, $amount);
        $this->config->save();
    }

    public function reduceMoney(string $player, float $amount) {
        $currentMoney = $this->getMoney($player);
        $newMoney = max(0, $currentMoney - $amount);
        $this->config->set($player, $newMoney);
        $this->config->save();
    }

    public function getDebt(string $player): float {
        return $this->debts->get($player, 0);
    }

    public function addDebt(string $player, float $amount) {
        $currentDebt = $this->getDebt($player);
        $newDebt = $currentDebt + $amount;
        $this->debts->set($player, $newDebt);
        $this->debts->save();
    }

    public function reduceDebt(string $player, float $amount) {
        $currentDebt = $this->getDebt($player);
        $newDebt = max(0, $currentDebt - $amount);
        $this->debts->set($player, $newDebt);
        $this->debts->save();
    }

    public function getTopMoney(int $page = 1, int $perPage = 10): array {
        $allMoney = $this->config->getAll();
        arsort($allMoney);
        return array_slice($allMoney, ($page - 1) * $perPage, $perPage, true);
    }

    public function save() {
        $this->config->save();
        $this->debts->save();
    }

    public function load() {
        $this->config->reload();
        $this->debts->reload();
    }
}
