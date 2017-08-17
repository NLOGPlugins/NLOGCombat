# NLOGCombat
* 총 플러그인

### 개발자 API
* PlayerShootEvent 를 통해 여러가지 작업을 할 수 있습니다.
* 자세한 내용은 <a href="https://github.com/NLOGPlugins/NLOGCombat/blob/master/src/nlog/NLOGCombat/PlayerShootEvent.php">PlayerShootEvent.php</a>를 참조해주세요.

##### 예제 코드
* 땅 영역에서의 총 사용 금지
```
<?php

namespace nlog;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use NLOGGun\PlayerShootEvent;
use ifteam\SimpleArea\database\area\AreaProvider;
use ifteam\SimpleArea\database\area\AreaSection;

class example extends PluginBase implements Listener {
	
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	/**
	 * 
	 * @priority HIGHEST
	 */
	public function handleShoot (PlayerShootEvent $event) {
		$player = $event->getPlayer();
		$areaSection = AreaProvider::getInstance()->getArea($player->getLevel(), $player->x, $player->z);
		if ($areaSection instanceof AreaSection) {
			$event->setCancelled(true);
			$player->sendMessage("땅에서 총으로 놀지마!!(ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ)");
		}
	}
	
}
```
