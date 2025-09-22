<?php

namespace SlotMachine;

use SlotMachine\Enums\SlotOption;

class SymbolGenerator
{
    public function generate(): SlotOption
    {
        $symbols = SlotOption::all();
        $totalWeight = array_sum(array_map(fn($s) => $s->weight(), $symbols));
        $random = rand(1, $totalWeight);
        $current = 0;
        
        foreach ($symbols as $symbol) {
            $current += $symbol->weight();
            if ($random <= $current) {
                return $symbol;
            }
        }
        
        return SlotOption::CHERRY; // Fallback
    }
}
