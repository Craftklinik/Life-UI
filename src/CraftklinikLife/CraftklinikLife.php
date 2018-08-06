<?php

namespace CraftklinikLife;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

use pocketmine\utils\TextFormat;

class CraftklinikLife extends PluginBase implements Listener {
	

	public function onEnable() {
		$this->getServer()->getPluginmanager()->registerEvents($this, $this);
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		
		switch($cmd->getName()){
			
			case "life":
				if($sender instanceof Player){
					$this->openMyForm($sender);
					if($sender->hasPermission("use.life")){
						$sender->sendMessage("Life");
					}
				}
			break;
		}
		return true;
	}
	
	public function openMyForm($player){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null){
			$result = $data;
			if($result === null){
				return true;
			}
			switch($result){
				case 0:
					if($player->hasPermission("life.heal")){
						$player->setHealth(20);
						$player->sendMessage("Du wurdest geheilt!");
						}
				break;
				
				case 1:
					if($player->hasPermission("life.food")){
						$player->setFood(20);
						$player->sendMessage("Du hast nun keinen Hunger mehr!");
					}
				break;
			}
			
			
		});
		$form->setTitle("Life - Menü");
		$form->setContent("Wahle einen Button!");
		$form->addButton("Heilen");
		$form->addButton("Essen");
		$form->sendToPlayer($player);
		return $form;
		
	}
}
