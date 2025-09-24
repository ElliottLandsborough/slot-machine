<?php

declare(strict_types=1);

namespace SlotMachine\Enums;

/**
 * Represents the symbols available in the slot machine game.
 * 
 * Each symbol has an associated payout value and weight for random selection.
 * 
 *  - Clarity: Defines all possible symbols in one place.
 *  - Type Safety: Prevents invalid symbols from being used.
 *  - Maintainability: Easy to add or modify symbols in one place.
 *  - Functionality: Encapsulates symbol-related logic (payout, weight) within the enum.
 *  - Easy to map to database/storage if needed.
 */
enum SlotOption: string
{
    case CHERRY = 'cherry';
    case LEMON = 'lemon'; 
    case ORANGE = 'orange';
    case GRAPES = 'grapes';
    case DIAMOND = 'diamond';
    
    public function payout(): int
    {
        // Sort of unfair on the user as, they don't know the payout, and their pay-in
        // is not in any way limited - like in real life where you could for example
        // deposit a maximum of 1 x £20 note? Or maybe the machine limits your max deposit?
        // anyway, this is a simple demo app, so we just have fixed payouts for each
        // symbol, if you get three of the same, you win that amount.
        return match($this) {
            self::CHERRY => 10,
            self::LEMON => 20,
            self::ORANGE => 30,
            self::GRAPES => 50,
            self::DIAMOND => 500,
        };
    }
    
    public function weight(): int
    {
        // More on this later, but this is used to give different probabilities
        // to the different symbols when randomly generating them.
        // Higher weight = more likely to be chosen.
        // Simple maths here, so CHERRY is most likely, DIAMOND least likely.
        // This is to simulate a real slot machine where high payout symbols
        // are more rare.
        return match($this) {
            self::CHERRY => 30,
            self::LEMON => 25,
            self::ORANGE => 20,
            self::GRAPES => 15,
            self::DIAMOND => 10,
        };
    }

    public static function all(): array
    {
        return self::cases();
    }
}
