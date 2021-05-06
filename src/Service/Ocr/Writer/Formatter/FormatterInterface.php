<?php

declare(strict_types=1);

namespace App\Service\Ocr\Writer\Formatter;

use App\Service\Ocr\Model\AccountNumberInterface;

interface FormatterInterface
{
    public function formatAccountNumberLine(AccountNumberInterface $accountNumber): string;
}
