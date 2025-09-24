<?php

declare(strict_types=1);

namespace SlotMachine;

use InvalidArgumentException;

// immutable class, once initialised we can't change anything.
// this is a simple value object to represent a bet.
// we validate the bet in the constructor.
// we have a method to get the amount of the bet.
// we could add more methods later if needed.
readonly class Bet
{
    /**
     * The user bets something, it must be positive
     * 
     * We set a private property and validate it in the constructor.
     * 
     * This is php magic, we could define it up top as a property.
     * 
     * @param int $amount 
     * @return void 
     * @throws InvalidArgumentException 
     */
    public function __construct(private int $amount)
    {
        if ($amount <= 0) throw new \InvalidArgumentException('Bet must be positive');
    }
    
    public function amount(): int { return $this->amount; }
}
