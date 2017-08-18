# NLOGCombat
* 총 플러그인

### 개발자 API
* PlayerShootEvent 를 통해 여러가지 작업을 할 수 있습니다.
* 자세한 내용은 <a href="https://github.com/NLOGPlugins/NLOGCombat/blob/master/src/nlog/NLOGCombat/PlayerShootEvent.php">PlayerShootEvent.php</a>를 참조해주세요.

##### 예제 코드
* 땅 영역에서의 총 사용 금지
```PHP
<?php

namespace nlog\NLOGTest;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener{
	
 	 public function onEnable(){
    	$this->getServer()->getPluginManager()->registerEvents($this, $this);
    	$this->getLogger()->notice("테스트용  플긴");
    	$this->getLogger()->notice("Made by NLOG (nlog.kro.kr)");
 	 }
 	 
 	 public function onHandlePickUpItem(PlayerItemHeldEvent $ev) {
 	 	$player = $ev->getPlayer();
 	 	if ($ev->getItem()->getId() === Item::TORCH) {
 	 		$ev->getPlayer()->getLevel()->setBlockLightAt($player->x, $player->y, $player->z, 14);
 	 	}
 	 }
  }
  
?>
```
