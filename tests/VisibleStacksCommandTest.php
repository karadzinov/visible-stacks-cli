<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use VisibleStacks\Commands\VisibleStacksCommand;

class VisibleStacksCommandTest extends TestCase
{
    public function testCommandOutputsVisibleCount()
    {
        $command = new VisibleStacksCommand();
        $tester = new CommandTester($command);
        $tester->setInputs(['y']); // Test mode selected
        $tester->execute([]);

        $output = $tester->getDisplay();
        $this->assertStringContainsString('Visible book stacks:', $output);
        $this->assertStringContainsString('📚 Book Stack Visibility Counter', $output);
    }
}
