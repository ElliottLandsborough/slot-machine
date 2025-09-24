<?php

namespace SlotMachine;

use SlotMachine\{Player, Bet, Credits, SymbolGenerator, SpinResult};
use SlotMachine\Enums\SlotOption;

/**
 * the core 'business logic' service for the slot machine game.
 *
 * @package SlotMachine
 */
class GameService
{
    public function __construct(private SymbolGenerator $generator) 
    {
    }
    
    // only supports one player at a time anyway for now
    public function createPlayer(string $id, int $startingCredits = 100): Player
    {
        return new Player($id, new Credits($startingCredits));
    }

    public function playSpin(Player $player, int $betAmount): SpinResult
    {
        // Create a bet with an amount
        $bet = new Bet($betAmount);
        // Spin the reels based on the created bet.
        // Use the generator to find out which symbols were won.
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
