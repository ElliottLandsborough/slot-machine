<?php

declare(strict_types=1);

namespace SlotMachine;

readonly class Bet
{
    public function __construct(private int $amount)
    {
        if ($amount <= 0) throw new \InvalidArgumentException('Bet must be positive');
    }
    
    public function amount(): int { return $this->amount; }
}
