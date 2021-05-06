<?php

declare(strict_types=1);

namespace App\Service\Ocr\Writer;

use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\Writer\Formatter\FormatterInterface;

class Writer implements WriterInterface
{
    private const FILE_MODE = 'w';

    private string $outputFilePath;
    private FormatterInterface $formatter;
    private ?\SplFileObject $file = null;

    public function __construct(
        string $outputFilePath,
        FormatterInterface $formatter
    ) {
        $this->outputFilePath = $outputFilePath;
        $this->formatter = $formatter;
    }

    public function write(AccountNumberInterface $accountNumber): void
    {
        $this->file = $this->file ?? new \SplFileObject($this->outputFilePath, self::FILE_MODE);

        $this->file->fwrite($this->formatter->formatAccountNumberLine($accountNumber));
    }
}
