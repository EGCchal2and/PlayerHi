<?php

namespace EGC\EGCPlayerhi;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
class Player extends PluginBase implements Listener{
	
	public $plconfig;
	public $plconfigData;
	
	public $plugin_version;
	
	public function onLoad(){
		$this->getServer()->getLogger()->info(TextFormat::GREEN . "[ 환영말 ] Player Hi 로드중 버전 1.0.0");
		$this->getServer()->getLogger()->info(TextFormat::BLUE . "[ 환영말 ] EGC Plugin start");
	}
	
	public function onEnable() {
		@mkdir($this->getDataFolder());
		
			$this->plconfig = new Config ($this->getDataFolder () . "hi.yml", Config::YAML, [
"HI" => "§b님 안녕하세요. 우리서버에 오신것을 환영합니다.",
"enter" => "§a카카오그룹에 저희서버를 검색하세요.",
"game" => "§c[ 게임종료 ]",
"message" => "§b님이 게임을 종료하셨습니다."
			] );
			$this->plconfigData = $this->plconfig->getAll();
			$this->plugin_version = $this->getDescription()->getVersion();
			$version = json_decode(Utils::getURL("https://raw.githubusercontent.com/EGCchal2and/versions/master/pluginversion.json"), true);
			if($this->plugin_version < $version["PlayerHi"]){
				$this->getLogger()->notice("PlayerHi 업데이트 되었습니다.");
				$this->getLogger()->notice("기존버전: ".$this->plugin_version.", 업데이트버전: ".$version["PlayerHi"]);
			}
			
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->getServer()->getLogger()->critical(TextFormat::RED . "[ 환영말 ]경고 : 이플러그인은 EGC-EULA로 보호 받고있습니다. 후원을 받으려면 카톡cmj12030으로 오셔서 합의를 보셔야 합니다. 합의금 : 만원");
	
	}
	public function save() {
		$this->plconfig->setAll($this->plconfigData);
		$this->plconfig->save();
	}
		
	public function onJoin(PlayerJoinEvent $Join){
		$HI = $this->plconfigData["HI"];
		$En = $this->plconfigData["enter"];
		$Pl = $Join->getPlayer()->getName();
		$Join->setJoinMessage("§a".$Pl."".$HI."\n".$En."");
	}
	public function onQuit(PlayerQuitEvent $Quit){
		$Pl = $Quit->getPlayer()->getName();
		$gm = $this->plconfigData["game"];
		$msg = $this->plconfigData["message"];
		$Quit->setQuitMessage("".$gm."§a".$Pl."".$msg."");
	}
	public function onDisable(){
		$this->save();
		$this->getServer()->getLogger()->info(TextFormat::GREEN . "[ 환영말 ] EGC Plugin stop");
	}
}
/*
 * 명령어추가 하기
 * 콘피그 추가하기..
 * 또 뭘하지?
 */
	
?>
