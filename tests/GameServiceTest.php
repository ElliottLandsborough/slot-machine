<?php

declare(strict_types=1);

namespace SlotMachine\Tests;

use PHPUnit\Framework\TestCase;
use SlotMachine\GameService;
use SlotMachine\SymbolGenerator;
use SlotMachine\Player;
use SlotMachine\Enums\SlotOption;

class GameServiceTest extends TestCase
{
    public function testCreatePlayerInitialCredits()
    {
        $generator = $this->createMock(SymbolGenerator::class);
        $service = new GameService($generator);

        $player = $service->createPlayer('test-user', 150);
        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals(150, $player->credits()->amount());
    }

    public function testPlayWhenSpinReturnsWinningSpinResult()
    {
        $generator = $this->createMock(SymbolGenerator::class);
        $generator->method('generate')->willReturn(SlotOption::DIAMOND);

        $service = new GameService($generator);

        $player = $service->createPlayer('test-user', 100);
        $result = $service->playSpin($player, 10);

        $this->assertEquals(3, count($result->symbols()));
        $this->assertTrue($result->isWin());
        $this->assertGreaterThan(0, $result->payout());
    }

    public function testPlayWhenSpinReturnsLosingSpinResult()
    {
        $generator = $this->createMock(SymbolGenerator::class);
        $generator->method('generate')->willReturnOnConsecutiveCalls(
            SlotOption::CHERRY,
            SlotOption::LEMON,
            SlotOption::ORANGE
        );

        $service = new GameService($generator);

        $player = $service->createPlayer('test-user', 100);
        $result = $service->playSpin($player, 10);

        $this->assertEquals(3, count($result->symbols()));
        $this->assertFalse($result->isWin());
        $this->assertEquals(0, $result->payout());
    }

    public function testGetPaytableFormat()
    {
        $generator = $this->createMock(SymbolGenerator::class);
        $service = new GameService($generator);

        $paytable = $service->getPaytable();
        $this->assertStringContainsString('PAYTABLE', $paytable);
        foreach (SlotOption::all() as $symbol) {
            $this->assertStringContainsString($symbol->value, $paytable);
            $this->assertStringContainsString((string)$symbol->payout(), $paytable);
        }
    }
}
