<?php

namespace SlotMachine;

use SlotMachine\Enums\SlotOption;
use SlotMachine\Enums\WinType;

/**
 * Define the result of a spin with currently three reels.
 * 
 * Set the results and also set if it's a win or not.
 * 
 * Looking at it now,
 * $sinType could be called seomthing more like $resultType?
 * Not sure why I called it winType when it can be a no-win.
 * Some of the naming in a lot of these classes could be improved.
 *
 * @package SlotMachine
 */
class SpinResult
{
    public function __construct(
        public readonly SlotOption $reel1,
        public readonly SlotOption $reel2, 
        public readonly SlotOption $reel3,
        public readonly WinType $winType,
        public readonly int $payout
    ) {}

    public function options(): array
    {
        return [$this->reel1, $this->reel2, $this->reel3];
    }

    public function isWin(): bool
    {
        return $this->winType !== WinType::NO_WIN;
    }

    public function payout(): int
    {
        return $this->payout;
    }

    public function __toString(): string
    {
        return $this->display();
    }

    public function symbols(): array
    {
        return $this->options();
    }
    
    // output reel symbols
    // output win/lose message
    // output the amount won if an amount was won
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
