<?php

namespace ParticleGiings;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use jojoe77777\FormAPI;

class Main extends PluginBase implements Listener{
	
    public $players = [];
    public $particle1 = array("CrownHeartParticles");
    public $particle2 = array("LaserParticles");
    public $particle3 = array("TornadoParticles");
    public $particle4 = array("SonicBoomParticles");
    public $particle5 = array("DringParticles");
    public $name = array();
	
    public function onEnable()
    {
	$this->getLogger()->info("[Enable] §bplugin created by Giings");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getScheduler()->scheduleRepeatingTask(new Particle($this), 5);
    }
	
    public function checkDepends(){
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if(is_null($this->formapi)){
            $this->getLogger()->info("[Disable] §cYou need FormAPI!");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }
	
	public function onCommand(CommandSender $player, Command $command, string $label, array $params) : bool
	{
	$name = $player->getName();
	    if(!$player instanceof Player){
		$player->sendMessage("Please use command in-game");
		return false;
	    }
            $username = strtolower($player->getName());
            if($command->getName() == "pui"){
                if(!($player instanceof Player)){
                        $player->sendMessage("§7 You don't have permission");
                        return true;
                }
                $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
                $form = $api->createSimpleForm(function (Player $player, $data){
                    $result = $data;
                    if ($result == null) {
                }
                switch ($result) {
                        case 0:
                            break;
                        case 1:
                        $command = "pcrownheart";
			            $this->getServer()->getCommandMap()->dispatch($player, $command);
			    break;
			case 2:
                        $command = "plaser";
			            $this->getServer()->getCommandMap()->dispatch($player, $command);
			    break;
			case 3:
                        $command = "ptornado";
			            $this->getServer()->getCommandMap()->dispatch($player, $command);
		            break;
			case 4:
                        $command = "psboom";
			            $this->getServer()->getCommandMap()->dispatch($player, $command);
			    break;
			case 5:
                        $command = "pdring";
			            $this->getServer()->getCommandMap()->dispatch($player, $command);
			    break;
						
                }
            });
            $form->setTitle("§l§ePARTICLE");
            $form->addButton("§c§lEXIT");
            $form->addButton("§0§lCROWN HEART");
            $form->addButton("§0§lLASER");
            $form->addButton("§0§lTORNADO");
            $form->addButton("§0§lSONIC BOOM");
            $form->addButton("§0§lDRING");
            $form->sendToPlayer($player);
        }
	if($command->getName() == "pcrownheart"){
            if(!in_array($name, $this->particle1)) {
				
	        $this->particle1[] = $name;
		$player->sendMessage("§l§eParticle §7> §fCrown Heart Enable");
			
	    } else {
			    
	        unset($this->particle1[array_search($name, $this->particle1)]);
		$player->sendMessage("§l§eParticle §7> §f Crown Heart Disable");
	    }
	}
	if($command->getName() == "plaser"){
	    if(!in_array($name, $this->particle2)) {
				
		$this->particle2[] = $name;
		$player->sendMessage("§l§eParticle §7> §fLaser Enable");
			
	    } else {
			    
		unset($this->particle2[array_search($name, $this->particle2)]);
		$player->sendMessage("§l§eParticle §7> §fLaser Disable");
	    }
	}
	if($command->getName() == "ptornado"){
	    if(!in_array($name, $this->particle3)) {
				
	        $this->particle3[] = $name;
                $player->sendMessage("§l§eParticle §7> §fTornado Enable");
		    
            } else {
		    
	        unset($this->particle3[array_search($name, $this->particle3)]);
	        $player->sendMessage("§l§eParticle §7> §fTornado Disable");
	    }
        }
	if($command->getName() == "psboom"){
	    if(!in_array($name, $this->particle4)) {
				
	        $this->particle4[] = $name;
		$player->sendMessage("§l§eParticle §7> §fSonic Boom Enable");
			
	    } else {
			    
		unset($this->particle4[array_search($name, $this->particle4)]);
		$player->sendMessage("§l§eParticle §7> §fSonic Boom Disable");
	     }
	 }
	 if($command->getName() == "pdring"){
	     if(!in_array($name, $this->particle5)) {
				
		 $this->particle5[] = $name;
		 $player->sendMessage("§l§eParticle §7> §fDring Enable");
			
	     } else {
			    
		 unset($this->particle5[array_search($name, $this->particle5)]);
		 $player->sendMessage("§l§eParticle §7> §fDring Disable");
	     }
	}
	return true;
    }
}

class Particle extends PluginTask {
	
	public function __construct($plugin) {
		$this->plugin = $plugin;
	}

	public function onRun($tick) {
		
	    foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
		$name = $player->getName();
		$inv = $player->getInventory();
			
		$players = $player->getLevel()->getPlayers();
		$level = $player->getLevel();
			
		$x = $player->getX();
		$y = $player->getY();
		$z = $player->getZ();
			
		if(in_array($name, $this->plugin->particle1)) {
				
		    $center = new Vector3($x, $y+0.8, $z);
		    $particle = new HeartParticle($center);
				
			$time = 1;
	                $pi = 3.14159;
	                $time = $time+0.1/$pi;
	                for($i = 0; $i <= 2*$pi; $i+=$pi/8){
			$x = $time*cos($i) + $center->x;
			$y = exp(-0.1*$time)*sin($time) + $center->y;
			$z = $time*sin($i) + $center->z;
					
			$particle->setComponents($x, $y+0.8, $z);
			$level->addParticle($particle);
						
		    }
	        }
		    
		if(in_array($name, $this->plugin->particle2)) {
				
		    $center = new Vector3($x, $y+0.5, $z);
	            $particle = new FlameParticle($center);
				
		    $direction = $player->getDirectionVector();
		    for($i = 0; $i < 40; ++$i){
		        $x = $i*$direction->x+$player->x;
	                $y = $i*$direction->y+$player->y;
	                $z = $i*$direction->z+$player->z;
					
	                $particle->setComponents($x, $y+0.5, $z);
	                $level->addParticle($particle);
						
		    }
                }
		    
	        if(in_array($name, $this->plugin->particle3)) {
				
		    $center = new Vector3($x, $y+0.5, $z);
	            $particle = new FlameParticle($center);
				
	            for($yaw = 0, $y = $center->y; $y < $center->y + 2; $yaw += (M_PI * 2) / 20, $y += 1 / 20){
                       $x = -sin($yaw) + $center->x;
                       $z = cos($yaw) + $center->z;
					
			$particle->setComponents($x, $y+0.5, $z);
			$level->addParticle($particle);
						
	            }
		}
		    
		if(in_array($name, $this->plugin->particle4)) {
				
		    $center = new Vector3($x, $y, $z);
	            $particle = new AngryVillagerParticle($center);
				
		    $time = 1;
	            $pi = 3.14159;
	            $time = $time+0.1/$pi;
	            for($i = 0; $i <= 2*$pi; $i+=$pi/8){
		        $x = $time*cos($i) + $player->x;
		        $z = exp(-0.1*$time)*sin($time) + $player->z;
			$y = $time*sin($i) + $player->y;
				
	                    $particle->setComponents($x, $y, $z);
		            $level->addParticle($particle);
				
		    }
		}
		    
		if(in_array($name, $this->plugin->particle5)) {
				
		    $center = new Vector3($x, $y, $z);
		    $particle = new WaterDripParticle($center);
				
		    $time = 1;
	            $pi = 3.14159;
	            $time = $time+0.1/$pi;
	            for($i = 0; $i <= 2*$pi; $i+=$pi/8){
		    $x = $time*cos($i) + $center->x;
		    $y = exp(-0.1*$time)*sin($time) + $center->y;
		    $z = $time*sin($i) + $center->z;
					
			$particle->setComponents($x, $y, $z);
			$level->addParticle($particle);
			    
		    }
		}
            
	    }
	
	}
	
}
