<?php

namespace nlog\NLOGCombat {

	use pocketmine\plugin\PluginBase;
	use pocketmine\event\Listener;
	use pocketmine\event\player\PlayerInteractEvent;
	use pocketmine\level\particle\DustParticle;
	use pocketmine\level\particle\DestroyBlockParticle;
	use pocketmine\math\Vector3;
	use pocketmine\block\Block;
	use pocketmine\event\entity\EntityDamageByEntityEvent;
	use pocketmine\level\particle\CriticalParticle;
	use pocketmine\entity\Creature;
																													
	class Main extends PluginBase implements Listener {
		
		public function onEnable() {
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
		}
		
		public function random() {
				$result = mt_rand() / mt_getrandmax();
				$result = (float) substr($result, 0, 14);
				return $result;
		}
		
		public function onIneract (PlayerInteractEvent $ev) {
			$player = $ev->getPlayer();
			if ($ev->getItem()->getId() === 369) { //블레이즈 막대
				
				$this->getServer()->getPluginManager()->callEvent($event = new PlayerShootEvent($player));
				
				if (!$event->isCancelled()) {
					
					$directonVector = $player->getDirectionVector();
					
					for ($i = 0; $i < 20; $i++) {
						$pos = $directonVector->multiply($i)->add($player);
						$pos->y = $pos->y + 1.7;
						
						if ($player->getLevel()->getBlockIdAt($pos->x, $pos->y, $pos->z) !== 0) {
							return;
						}
						
						$particle = new DustParticle($pos, 0, 0, 0);
						$player->getLevel()->addParticle($particle);
						
						foreach ($player->getLevel()->getEntities() as $ent) {
							if ($ent === $player) {
								continue;
							}
							if (!$ent instanceof Creature) {
								continue;
							}
							if (!isset($temp)) {
								$temp = $ent;
							}else{
								if ($ent->distance($pos) < $temp->distance($pos)) {
									$temp = $ent;
								}
							}
						}
						
						if (isset($temp)) {
							if ($temp->distance($pos) < 2) {
								$dmg = mt_rand(0, 7);
								$this->getServer()->getPluginManager()->callEvent($event = new EntityDamageByEntityEvent($player, $temp, EntityDamageByEntityEvent::CAUSE_ENTITY_ATTACK, $dmg));
								if (!$event->isCancelled()) {
									$temp->setHealth($temp->getHealth() - $dmg);
									if ($dmg === 0) {
										$msg = "미스가";
									}
									if ($dmg > 0 && $dmg < 6) {
										$msg = "보통이";
										$par = new DestroyBlockParticle(new Vector3($temp->x, $temp->y, $temp->z), new Block(Block::REDSTONE_BLOCK));
										$player->getLevel()->addParticle($par);
									}
									if ($dmg > 5) {
										$msg = "크리티컬이";
										$par = new DestroyBlockParticle(new Vector3($temp->x, $temp->y, $temp->z), new Block(Block::REDSTONE_BLOCK));
										$player->getLevel()->addParticle($par);
										for ($b = 1; $b < 4; $b++) {
											$crit = new CriticalParticle(new Vector3($temp->x, $temp->y, $temp->z));
											$crit->setComponents(
													$crit->x + ($this->random() * 2 - 1) * 2,
													$crit->y + ($this->random() * 2 - 1) + 1,
													$crit->z + ($this->random() * 2 - 1) * 2
											);
											$player->getLevel()->addParticle($crit);
										}
									}
									$player->sendMessage("데미지 : {$dmg}, {$msg} 떴습니다!");
								}//EntityDamageByEntityEvent 작업
								return;
							}//엔티티 거리 체크
						}//엔티티 작업
					}//파티클 작업
				}//이벤트 작업
			}//아이템 작업
		}
	}
}