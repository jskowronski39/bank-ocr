<?php

declare(strict_types=1);

namespace App\Service\Ocr\Reader;

interface ReaderInterface
{
    public function readNumber(string $filePath): \Traversable;
}
