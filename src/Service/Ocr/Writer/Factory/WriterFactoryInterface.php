<?php

declare(strict_types=1);

namespace App\Service\Ocr\Writer\Factory;

use App\Service\Ocr\Writer\Formatter\FormatterInterface;
use App\Service\Ocr\Writer\WriterInterface;

interface WriterFactoryInterface
{
    public function create(string $outputFilePath, FormatterInterface $formatter): WriterInterface;

    public function createFromInputFile(
        string $inputFilePath,
        FormatterInterface $formatter,
        ?string $fileName = null
    ): WriterInterface;
}
