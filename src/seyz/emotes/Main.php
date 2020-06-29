<?php

namespace seyz\emotes;

use pocketmine\{
    Player,
    Server,
    plugin\PluginBase,
    event\Listener,
    event\server\DataPacketReceiveEvent,
    network\mcpe\protocol\EmoteListPacket,
    network\mcpe\protocol\EmotePacket
};

class Main extends PluginBase implements Listener {
    
    public const EMOTE_WAVE = "4c8ae710-df2e-47cd-814d-cc7bf21a3d67";
    public const EMOTE_OVER_THERE = "ce5c0300-7f03-455d-aaf1-352e4927b54d";
    public const EMOTE_CLAP = "9a469a61-c83b-4ba9-b507-bdbe64430582";
    
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onDataPacket(DataPacketReceiveEvent $ev): void
    {
        $pl = $ev->getPlayer();
        $pk = $ev->getPacket();
        
        if($pk instanceof EmoteListPacket){
            // ToDo
        } elseif($pk instanceof EmotePacket){
            $emoteId = $pk->getEmoteId();
            
            $this->doEmote($pl, $emoteId);
        }
    }
    
    public function doEmote(Player $pl, string $emote): void
    {
        $pk = EmotePacket::create($pl->getId(), $emote, 0 << 1);
        
        Server::getInstance()->broadcastPacket($pl->getViewers(), $pk);
    }
}
