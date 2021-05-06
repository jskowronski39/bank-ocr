<?php

declare(strict_types=1);

namespace App\Service\Ocr\Writer;

use App\Service\Ocr\Model\AccountNumberInterface;

interface WriterInterface
{
    public function write(AccountNumberInterface $accountNumber): void;
}
