<?php

declare(strict_types=1);

namespace App\Service\Ocr\Writer\Factory;

use App\Service\Ocr\Writer\Formatter\FormatterInterface;
use App\Service\Ocr\Writer\Writer;
use App\Service\Ocr\Writer\WriterInterface;

class WriterFactory implements WriterFactoryInterface
{
    public function create(string $outputFilePath, FormatterInterface $formatter): WriterInterface
    {
        return new Writer($outputFilePath, $formatter);
    }

    public function createFromInputFile(
        string $inputFilePath,
        FormatterInterface $formatter,
        ?string $fileName = null
    ): WriterInterface {
        $outputDirectory = \dirname($inputFilePath);
        $fileName = $fileName ?? basename($inputFilePath).'_'.(new \DateTime())->format('YmdHis');
        $outputFilePath = $outputDirectory.'/'.$fileName;

        return new Writer($outputFilePath, $formatter);
    }
}
