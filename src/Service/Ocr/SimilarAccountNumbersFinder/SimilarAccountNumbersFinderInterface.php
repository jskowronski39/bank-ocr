<?php

declare(strict_types=1);

namespace App\Service\Ocr\SimilarAccountNumbersFinder;

use App\Service\Ocr\Model\AccountNumberInterface;

interface SimilarAccountNumbersFinderInterface
{
    public function findSimilarAccountNumbers(AccountNumberInterface $accountNumber): array;
}
