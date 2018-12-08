<?php

namespace HitTeleport;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEvent;
use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\level;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info("HitTeleportを読み込みました");
    $this->Config = new Config($this->getDataFolder() ."Config.yml", Config::YAML, array(
       "itemid" => "450",
       "x" => "1",
       "t" => "4",
       "z" => "1",
       "world" => "world"
    ));
  }    
  
  public function onDamage(EntityDamageEvent $event){
      if($event instanceof EntityDamageByEntityEvent){
          $damager = $event->getDamager();
          $entity = $event->getEntity();
          $itemid = $this->Config->get("itemid");
          $x = $this->Config->get("x");
          $y = $this->Config->get("t");
          $z = $this->Config->get("z");
          $world = $this->Config->get("world");
          if($damager instanceof Player && $entity instanceof Player){
              $item = $damager->getInventory()->getItemInHand();
              if($item->getId() === $itemid){
                  $event->setCancelled();
                  $pos = new Position($x,$y,$z, $this->getServer()->getLevelByName("{$world}"));
                  $abc = $entity->getName();
                  $def = $damager->getName();
                  $entity->teleport($pos);
                  $this->getServer()->broadcastMessage("§e{$abc}§cは§e{$def}§cに捕まりました！");
              }
          }
      }
  }
}
