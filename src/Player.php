<?php

namespace SlotMachine;

use SlotMachine\Bet;
use SlotMachine\Credits;
use SlotMachine\Enums\WinType;
use SlotMachine\SymbolGenerator;
use SlotMachine\SpinResult;

class Player
{
    public function __construct(
        private string $id,
        private Credits $credits
    ) {}
    
    public function id(): string 
    { 
        return $this->id; 
    }
    
    public function credits(): Credits 
    { 
        return $this->credits; 
    }
    
    public function spin(Bet $bet, SymbolGenerator $generator): SpinResult
    {
        // Business rule: Can't bet more than you have
        if (!$this->credits->canAfford($bet->amount())) {
            throw new \DomainException('Insufficient credits for this bet');
        }
        
        // Deduct bet
        $this->credits = $this->credits->subtract($bet->amount());
        
        // Generate symbols
        $reel1 = $generator->generate();
        $reel2 = $generator->generate();
        $reel3 = $generator->generate();
        
        // Determine win type
        $winType = ($reel1 === $reel2 && $reel2 === $reel3) 
            ? WinType::JACKPOT 
            : WinType::NO_WIN;
        
        // Calculate payout
        $payout = 0;
        if ($winType === WinType::JACKPOT) {
            $payout = $reel1->payout() * $bet->amount();
            $this->credits = $this->credits->add($payout);
        }
        
        return new SpinResult($reel1, $reel2, $reel3, $winType, $payout);
    }
    
    public function addCredits(int $amount): void
    {
        $this->credits = $this->credits->add($amount);
    }
}