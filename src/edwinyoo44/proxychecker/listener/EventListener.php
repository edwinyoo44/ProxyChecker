<?php

namespace ProxyChecker\listener;

use pocketmine\plugin\Plugin;
use pocketmine\event\Listener;
use pocketmine\Server;

use pocketmine\event\player\PlayerPreLoginEvent;

use libIPGeolocation\IPGeolocation;

class EventListener implements Listener {

	private $plugin;
	
	public function __construct(Plugin $plugin){
		$this->plugin = $plugin;
	}
    
	/**
	 * @param PlayerPreLoginEvent $event
     * 
     * @priority LOWEST
     */
	public function onPlayerPreLogin(PlayerPreLoginEvent $event): void {
		if ($this->plugin->getConfig()->get("allow-localhost", true)) {
			if (IPGeolocation::getContinent($event->getIp()) === "localhost") {
				return;
			}
		}

		if ($this->plugin->getConfig()->get("allow-proxy", false)) return;

		if (IPGeolocation::isProxy($event->getIp())) {
			$event->setKickReason(PlayerPreLoginEvent::KICK_REASON_PLUGIN, $this->plugin->getConfig()->get("kick-messages", "You seem to be using a VPN or Proxy."));
			return;
		}
		
		return;
    }

}
