<?php

declare(strict_types=1);

namespace App\Tests\Service\Ocr\Reader;

use App\Service\Ocr\Reader\Reader;
use App\Service\Ocr\Reader\ReaderInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \App\Service\Ocr\Reader\Reader
 */
final class ReaderTest extends TestCase
{
    private ReaderInterface $reader;

    protected function setUp(): void
    {
        parent::setUp();

        $this->reader = new Reader(27, 3, 1);
    }

    /**
     * @test
     */
    public function reads_numbers_from_file(): void
    {
        $filePath = __DIR__.'/../../../../data/numbers';
        $expectedNumbersFilePath = __DIR__.'/../../../../data/numbers_as_strings';

        $expectedNumbers = explode("\n", file_get_contents($expectedNumbersFilePath));
        $numbers = iterator_to_array($this->reader->readNumber($filePath));

        static::assertSame($expectedNumbers, $numbers);
    }
}
