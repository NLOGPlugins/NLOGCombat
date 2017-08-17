<?php

namespace nlog\NLOGCombat;

use pocketmine\event\Event;
use pocketmine\event\Cancellable;
use pocketmine\Player;

/**
 * 플레이어가 총을 쏠 때 이벤트입니다.
 * 
 * @author NLOG
 */
class PlayerShootEvent extends Event implements Cancellable {
	
	public static $handlerList = null;
	
	/** @var Player */
	private $player;
	
	/**
	 * 
	 * @param Player $shooter
	 * @param int $damage
	 */
	public function __construct(Player $shooter) {
		$this->player = $shooter;
	}
	
	/**
	 * @return Player
	 */
	public function getPlayer() {
		return $this->player;
	}
	
}