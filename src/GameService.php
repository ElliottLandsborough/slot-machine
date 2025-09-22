<?php

namespace SlotMachine;

use SlotMachine\{Player, Bet, Credits, SymbolGenerator, SpinResult};
use SlotMachine\Enums\SlotOption;

class GameService
{
    public function __construct(private SymbolGenerator $generator) 
    {
    }
    
    public function createPlayer(string $id, int $startingCredits = 100): Player
    {
        return new Player($id, new Credits($startingCredits));
    }
    
    public function playSpin(Player $player, int $betAmount): SpinResult
    {
        $bet = new Bet($betAmount);
        return $player->spin($bet, $this->generator);
    }
    
    public function getPaytable(): string
    {
        $table = "\n PAYTABLE \n";
        $table .= "═══════════════════\n";
        
        foreach (SlotOption::all() as $symbol) {
            $table .= "{$symbol->value} {$symbol->value} {$symbol->value} = {$symbol->payout()} credits\n";
        }
        
        $table .= "═══════════════════\n\n";
        return $table;
    }
}