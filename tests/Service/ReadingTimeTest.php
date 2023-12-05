<?php

namespace App\Tests\Service;

use App\Service\ReadingTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReadingTimeTest extends KernelTestCase
{
    /**
     * @dataProvider provideContent
     */
    public function testCalculate(string $expected, string $content): void
    {
        $kernel = self::bootKernel();
        $readingTime = static::getContainer()->get(ReadingTime::class);

        $this->assertSame($expected, $readingTime->calculate($content));
    }

    public function provideContent()
    {
        return [
            ['1 min', trim(str_repeat('word ', 250))],
            ['2 min', trim(str_repeat('word ', 500))],
            ['3 min', trim(str_repeat('word ', 650))],
        ];
    }
}
