<?php

namespace SlotMachine;

use SlotMachine\Enums\SlotOption;
use SlotMachine\Enums\WinType;

class SpinResult
{
    public function __construct(
        public readonly SlotOption $reel1,
        public readonly SlotOption $reel2, 
        public readonly SlotOption $reel3,
        public readonly WinType $winType,
        public readonly int $payout
    ) {}
    
    public function display(): string
    {
        $result = "\n";
        $result .= "{$this->reel1->value} │ {$this->reel2->value} │ {$this->reel3->value}\n";
        $result .= "\n\n";
        
        $result .= $this->winType->message() . "\n";
        
        if ($this->winType === WinType::JACKPOT) {
            $result .= "You won {$this->payout} credits!\n";
        }
        
        return $result;
    }
}
