#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use SlotMachine\Enums\WinType;
use SlotMachine\GameService;
use SlotMachine\SymbolGenerator;

/**
 * This file acts like the display layer / controller for the slot machine game.
 * It uses the GameService to manage game state and player actions.
 * 
 * A glaring issue: there is no persistence layer, so if you exit the app,
 * you lose all your credits and stats. This could be fixed by adding
 * a simple file or database storage layer, but for this demo, it's kept simple.
 * 
 * Another glaring issue: no user authentication or security.
 * 
 * Final glaring issue: no input validation or error handling.
 * 
 * And on top of that, the code is a bit messy and could be better organized.
 * This is just in a single file for simplicity, but in a real app,
 * you'd want to separate concerns better, put it in its iwn display class,
 * have some templates, or even a web interface instead of CLI.
 * 
 * @return void 
 */

function clearScreen(): void 
{
    system('clear');
}

function readInput(string $prompt): string 
{
    echo $prompt;
    return trim(fgets(STDIN));
}

function pressEnterToContinue(): void 
{
    echo "\nPress ENTER to continue...";
    fgets(STDIN);
}

function displayHeader(): void 
{
    echo "══════════════════════════════════════════════\n";
    echo "               SLOT MACHINE CLI               \n";
    echo "══════════════════════════════════════════════\n\n";
}

function displayMenu(): void 
{
    echo "┌─────────────────────────────────┐\n";
    echo "│            MAIN MENU            │\n";
    echo "├─────────────────────────────────┤\n";
    echo "│ 1. Play Slot Machine            │\n";
    echo "│ 2. View Paytable                │\n";
    echo "│ 3. Add Credits                  │\n";
    echo "│ 4. View Player Stats            │\n";
    echo "│ 5. Exit                         │\n";
    echo "└─────────────────────────────────┘\n\n";
}

// Main Application
try {
    clearScreen();
    displayHeader();

    // Setup game service
    $gameService = new GameService(new SymbolGenerator());
    
    // Get player name
    $playerName = readInput("Enter your player name: ");
    if (empty($playerName)) $playerName = "Anonymous";
    
    $startingCredits = (int)readInput("Enter starting credits (default 100): ") ?: 100;
    $player = $gameService->createPlayer($playerName, $startingCredits);
    
    echo "\nWelcome {$playerName}! You start with {$player->credits()->amount()} credits.\n";
    pressEnterToContinue();

    // Main game loop
    while (true) {
        clearScreen();
        displayHeader();
        echo "Player: {$playerName} | Credits: {$player->credits()->amount()}\n\n";
        displayMenu();
        
        $choice = readInput("Choose an option (1-5): ");
        
        switch ($choice) {
            case '1': // Play Slot Machine
                clearScreen();
                displayHeader();
                echo "Player: {$playerName} | Credits: {$player->credits()->amount()}\n\n";
                
                if ($player->credits()->amount() <= 0) {
                    echo "You have no credits left! Add more credits to continue playing.\n";
                    pressEnterToContinue();
                    break;
                }
                
                $maxBet = min($player->credits()->amount(), 50);
                $betAmount = (int)readInput("Enter bet amount (1-{$maxBet}): ");
                
                if ($betAmount <= 0 || $betAmount > $maxBet) {
                    echo "Invalid bet amount!\n";
                    pressEnterToContinue();
                    break;
                }
                
                try {
                    echo "\nSpinning the reels...\n";
                    sleep(1); // Add suspense
                    
                    $result = $gameService->playSpin($player, $betAmount);
                    echo "\n" . $result->display();
                    echo "\nCredits after spin: {$player->credits()->amount()}\n";
                    
                    if ($result->winType === WinType::JACKPOT) {
                        echo "AMAZING WIN!\n";
                    }
                    
                } catch (Exception $e) {
                    echo "Error: {$e->getMessage()}\n";
                }
                
                pressEnterToContinue();
                break;
                
            case '2': // View Paytable
                clearScreen();
                displayHeader();
                echo $gameService->getPaytable();
                echo "Tip: Higher bets multiply your winnings!\n";
                pressEnterToContinue();
                break;
                
            case '3': // Add Credits
                clearScreen();
                displayHeader();
                echo "Current credits: {$player->credits()->amount()}\n\n";
                $addAmount = (int)readInput("How many credits to add? ");
                
                if ($addAmount > 0) {
                    $player->addCredits($addAmount);
                    echo "Added {$addAmount} credits!\n";
                    echo "New balance: {$player->credits()->amount()} credits\n";
                } else {
                    echo "Invalid amount!\n";
                }
                
                pressEnterToContinue();
                break;
                
            case '4': // View Player Stats
                clearScreen();
                displayHeader();
                echo "═══ PLAYER STATISTICS ═══\n";
                echo "Player Name: {$playerName}\n";
                echo "Current Credits: {$player->credits()->amount()}\n";
                echo "Starting Credits: {$startingCredits}\n";
                
                $netChange = $player->credits()->amount() - $startingCredits;
                if ($netChange > 0) {
                    echo "Net Gain: +{$netChange} credits\n";
                } elseif ($netChange < 0) {
                    echo "Net Loss: {$netChange} credits\n";
                } else {
                    echo "Net Change: Even\n";
                }
                echo "═══════════════════════════\n";
                
                pressEnterToContinue();
                break;
                
            case '5': // Exit
                clearScreen();
                displayHeader();
                echo "Thanks for playing, {$playerName}!\n";
                
                $finalCredits = $player->credits()->amount();
                $netChange = $finalCredits - $startingCredits;
                
                echo "Final Credits: {$finalCredits}\n";
                if ($netChange > 0) {
                    echo "You won {$netChange} credits overall! Well done!\n";
                } elseif ($netChange < 0) {
                    echo "You lost " . abs($netChange) . " credits. Better luck next time!\n";
                } else {
                    echo "You broke even. Not bad!\n";
                }
                
                echo "\nGoodbye!\n";
                exit(0);
                
            default:
                echo "Invalid choice. Please select 1-5.\n";
                pressEnterToContinue();
                break;
        }
    }

} catch (Exception $e) {
    echo "Application Error: {$e->getMessage()}\n";
    echo "Please try again or contact support.\n";
    exit(1);
}