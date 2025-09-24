<?php

declare(strict_types=1);

namespace SlotMachine\Enums;

/**
 * Same thing for the win type, we define a 
 * sort of, state, of a roll. Maybe in the future we want to
 * chain the rolls to have more complex win types?
 */
enum WinType
{
    case NO_WIN;
    case JACKPOT;
    
    public function multiplier(): float
    {
        return match($this) {
            self::NO_WIN => 0.0,
            self::JACKPOT => 1.0
        };
    }
    
    public function message(): string
    {
        return match($this) {
            self::NO_WIN => 'No win this time.',
            self::JACKPOT => 'JACKPOT! Three matching symbols!'
        };
    }
}
