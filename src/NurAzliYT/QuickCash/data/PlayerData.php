<?php

namespace NurAzliYT\QuickCash\data;

use pocketmine\utils\Config;

class PlayerData {

    private Config $config;

    public function __construct(string $dataFolder) {
        @mkdir($dataFolder);
        $this->config = new Config($dataFolder . "PlayerData.yml", Config::YAML, [
            'players' => []
        ]);
    }

    public function getMoney(string $playerName): int {
        $players = $this->config->get("players", []);
        return $players[$playerName]['money'] ?? 0;
    }

    public function setMoney(string $playerName, int $amount): void {
        $players = $this->config->get("players", []);
        $players[$playerName]['money'] = $amount;
        $this->config->set("players", $players);
        $this->config->save();
    }

    public function addMoney(string $playerName, int $amount): void {
        $money = $this->getMoney($playerName);
        $this->setMoney($playerName, $money + $amount);
    }

    public function takeMoney(string $playerName, int $amount): void {
        $money = $this->getMoney($playerName);
        $this->setMoney($playerName, max(0, $money - $amount));
    }

    public function getDebt(string $playerName): int {
        $players = $this->config->get("players", []);
        return $players[$playerName]['debt'] ?? 0;
    }

    public function setDebt(string $playerName, int $amount): void {
        $players = $this->config->get("players", []);
        $players[$playerName]['debt'] = $amount;
        $this->config->set("players", $players);
        $this->config->save();
    }

    public function addDebt(string $playerName, int $amount): void {
        $debt = $this->getDebt($playerName);
        $this->setDebt($playerName, $debt + $amount);
    }

    public function takeDebt(string $playerName, int $amount): void {
        $debt = $this->getDebt($playerName);
        $this->setDebt($playerName, max(0, $debt - $amount));
    }

    public function save(): void {
        $this->config->save();
    }

    public function load(): void {
        $this->config->reload();
    }
}
