<?php

declare(strict_types=1);

namespace App\Service\Ocr\SimilarAccountNumbersFinder;

use App\Service\Ocr\Model\AccountNumber;
use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\SimilarDigitsFinder\SimilarDigitsFinderInterface;

class SimilarAccountAccountNumbersFinder implements SimilarAccountNumbersFinderInterface
{
    private SimilarDigitsFinderInterface $similarDigitsFinder;

    public function __construct(SimilarDigitsFinderInterface $similarDigitsFinder)
    {
        $this->similarDigitsFinder = $similarDigitsFinder;
    }

    public function findSimilarAccountNumbers(AccountNumberInterface $accountNumber): array
    {
        $similarAccountNumbers = [];

        foreach ($accountNumber->getDigits() as $position => $digit) {
            $similarDigits = $this->similarDigitsFinder->findSimilarDigits($digit);

            foreach ($similarDigits as $similarDigit) {
                $similarNumberDigitsArray = $accountNumber->getDigits();
                $similarNumberDigitsArray[$position] = $similarDigit;
                $similarAccountNumbers[] = new AccountNumber($similarNumberDigitsArray);
            }
        }

        return $similarAccountNumbers;
    }
}
