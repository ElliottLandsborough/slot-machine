<?php

namespace SlotMachine;

/**
 * Simple value object to represent player credits.
 * 
 * This is like the user's wallet within the slot machine.
 * 
 * Basic maths in here let us keep the Credits immutable.
 * 
 * Add/subtract, and canAfford methods.
 * 
 * @package SlotMachine
 */
readonly class Credits
{
    public function __construct(private int $amount)
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Credits cannot be negative');
        }
    }

    public function amount(): int 
    { 
        return $this->amount; 
    }
    
    public function subtract(int $amount): Credits 
    {
        if ($this->amount < $amount) {
            throw new \DomainException('Insufficient credits');
        }
        return new self($this->amount - $amount);
    }
    
    public function add(int $amount): Credits 
    {
        return new self($this->amount + $amount);
    }
    
    public function canAfford(int $amount): bool
    {
        return $this->amount >= $amount;
    }
}
