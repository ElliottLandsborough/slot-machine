<?php

declare(strict_types=1);

namespace SlotMachine\Enums;

enum SlotOption: string
{
    case CHERRY = 'cherry';
    case LEMON = 'lemon'; 
    case ORANGE = 'orange';
    case GRAPES = 'grapes';
    case DIAMOND = 'diamond';
    
    public function payout(): int
    {
        return match($this) {
            self::CHERRY => 10,
            self::LEMON => 20,
            self::ORANGE => 30,
            self::GRAPES => 50,
            self::DIAMOND => 500
        };
    }
    
    public function weight(): int
    {
        return match($this) {
            self::CHERRY => 30,
            self::LEMON => 25,
            self::ORANGE => 20,
            self::GRAPES => 15,
            self::DIAMOND => 10
        };
    }

    public static function all(): array
    {
        return self::cases();
    }
}