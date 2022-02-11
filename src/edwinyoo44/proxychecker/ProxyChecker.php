<?php

namespace ProxyChecker;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;

use ProxyChecker\listener\EventListener;

class ProxyChecker extends PluginBase {

	private static $instance;
	
	public function onLoad(): void {
		self::$instance = $this;
		return;
	}

	public function onEnable(): void {
		$this->saveDefaultConfig();
        Server::getInstance()->getPluginManager()->registerEvents(new EventListener($this), $this);
		return;
	}

	public function onDisable(): void {
		return;
	}

	public static function getInstance(): self {
		return self::$instance;
	}
}
