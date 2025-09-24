<?php

namespace SlotMachine;

use SlotMachine\Enums\SlotOption;

class SymbolGenerator
{
    /**
     * Generate a random symbol based on defined weights.
     * 
     * The generate funcion in here uses a weighted random selection
     * algorithm to return a SlotOption based on its weight.
     * 
     * 1. Get all possible symbols: it calls SlotOption::all() to retrieve
     *    all defined symbols.
     * 2. Calculate total weight: it sums up the weights of all symbols.
     * 3. Generate random number: it generates a random number between 1
     *    and the total weight.
     * 4. Select symbol: it iterates through the symbols, accumulating their
     *    weights until the accumulated weight exceeds the random number.
     *    The corresponding symbol is selected.
     * 5. Return symbol: it returns the selected symbol.
     * 
     * Fallback to CHERRY if something goes wrong.
     * 
     * This ensures that symbols with higher weights are more likely to be chosen,
     * again, quite simple maths here.
     * 
     * @return SlotOption
     */
    public function generate(): SlotOption
    {
        // get all symbols
        $symbols = SlotOption::all();
        // add all weights together
        $totalWeight = array_sum(array_map(fn($s) => $s->weight(), $symbols));
        // pick a random number between 1 and the above total.
        $random = rand(1, $totalWeight);

        $current = 0;

        // loop through symbols and their weights again
        foreach ($symbols as $symbol) {
            // keep a running total
            $current += $symbol->weight();
            // if the random number is less than the running total
            if ($random <= $current) {
                // we have a match and can exit
                return $symbol;
            }
        }
        
        // fallback to the CHERRY if something goes wrong.
        // NOTE: Do we want to hardcode cherry? Or pick a random one?
        // Or throw an exception and break the game for the user?
        // Need more planning here.
        return SlotOption::CHERRY;
    }
}
