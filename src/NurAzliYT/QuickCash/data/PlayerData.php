<?php

namespace NurAzliYT\QuickCash;

use pocketmine\utils\Config;

class PlayerData {
    private Main $plugin;
    private array $data;
    private Config $config;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->config = new Config($this->plugin->getDataFolder() . "players.yml", Config::YAML);
        $this->data = $this->config->getAll();
    }

    public function getMoney(string $player): int {
        return $this->data[$player]['money'] ?? 0;
    }

    public function getDebt(string $player): int {
        return $this->data[$player]['debt'] ?? 0;
    }

    public function addMoney(string $player, int $amount): void {
        if (!isset($this->data[$player])) {
            $this->data[$player] = ['money' => 0, 'debt' => 0];
        }
        $this->data[$player]['money'] += $amount;
        $this->save();
    }

    public function takeMoney(string $player, int $amount): void {
        if (isset($this->data[$player])) {
            $this->data[$player]['money'] = max(0, $this->data[$player]['money'] - $amount);
            $this->save();
        }
    }

    public function setMoney(string $player, int $amount): void {
        if (!isset($this->data[$player])) {
            $this->data[$player] = ['money' => 0, 'debt' => 0];
        }
        $this->data[$player]['money'] = $amount;
        $this->save();
    }

    public function addDebt(string $player, int $amount): void {
        if (!isset($this->data[$player])) {
            $this->data[$player] = ['money' => 0, 'debt' => 0];
        }
        $this->data[$player]['debt'] += $amount;
        $this->save();
    }

    public function takeDebt(string $player, int $amount): void {
        if (isset($this->data[$player])) {
            $this->data[$player]['debt'] = max(0, $this->data[$player]['debt'] - $amount);
            $this->save();
        }
    }

    public function getTopPlayers(): array {
        uasort($this->data, fn($a, $b) => $b['money'] <=> $a['money']);
        return array_slice($this->data, 0, 10, true);
    }

    public function save(): void {
        $this->config->setAll($this->data);
        $this->config->save();
    }

    public function load(): void {
        $this->data = $this->config->getAll();
    }
}
