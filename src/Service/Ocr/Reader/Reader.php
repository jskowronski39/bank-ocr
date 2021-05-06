<?php

declare(strict_types=1);

namespace App\Service\Ocr\Reader;

class Reader implements ReaderInterface
{
    private int $numberLineLength;
    private int $numberLineHeight;
    private int $emptyLinesToSkip;

    public function __construct(int $numberLineLength, int $numberLineHeight, int $emptyLinesToSkip)
    {
        $this->numberLineLength = $numberLineLength;
        $this->numberLineHeight = $numberLineHeight;
        $this->emptyLinesToSkip = $emptyLinesToSkip;
    }

    public function readNumber(string $filePath): \Traversable
    {
        $file = new \SplFileObject($filePath);
        $file->openFile();

        $number = '';
        $lineNumber = 1;
        $numberTotalLineHeight = $this->numberLineHeight + $this->emptyLinesToSkip;

        while (!$file->eof() && ($line = $file->fgets()) !== false) {
            if (1 === $lineNumber) {
                $number = '';
            }

            if ($lineNumber <= $this->numberLineHeight) {
                $number .= substr($line, 0, $this->numberLineLength);
                ++$lineNumber;

                continue;
            }

            if ($lineNumber === $numberTotalLineHeight) {
                $lineNumber = 1;

                yield $number;
            }
        }
    }
}
