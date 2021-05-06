<?php

declare(strict_types=1);

namespace App\Service\Ocr\Writer\Formatter;

use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\SimilarAccountNumbersFinder\SimilarAccountNumbersFinderInterface;
use App\Service\Ocr\Validator\ValidatorInterface;

class AmbiguousFormatter implements FormatterInterface
{
    private ValidatorInterface $validator;
    private SimilarAccountNumbersFinderInterface $similarAccountNumbersFinder;
    private string $illegibleStatus;
    private string $ambiguousStatus;

    public function __construct(
        ValidatorInterface $validator,
        SimilarAccountNumbersFinderInterface $similarAccountNumbersFinder,
        string $illegibleStatus,
        string $ambiguousStatus
    ) {
        $this->validator = $validator;
        $this->similarAccountNumbersFinder = $similarAccountNumbersFinder;
        $this->illegibleStatus = $illegibleStatus;
        $this->ambiguousStatus = $ambiguousStatus;
    }

    public function formatAccountNumberLine(AccountNumberInterface $accountNumber): string
    {
        if (!$accountNumber->containsIllegibleDigits() && $this->validator->isChecksumValid($accountNumber)) {
            return $this->formatLine($accountNumber);
        }

        $validSimilarAccountNumbers = [];
        $similarAccountNumbers = $this->similarAccountNumbersFinder->findSimilarAccountNumbers($accountNumber);
        foreach ($similarAccountNumbers as $similarAccountNumber) {
            if (!$similarAccountNumber->containsIllegibleDigits() && $this->validator->isChecksumValid($similarAccountNumber)) {
                $validSimilarAccountNumbers[] = $similarAccountNumber;
            }
        }

        switch (\count($validSimilarAccountNumbers)) {
            case 0:
                return $this->formatLine($accountNumber, $this->illegibleStatus);

            case 1:
                return $this->formatLine(array_pop($validSimilarAccountNumbers));

            default:
                return $this->formatLine($accountNumber, $this->ambiguousStatus, $validSimilarAccountNumbers);
        }
    }

    private function formatLine(
        AccountNumberInterface $accountNumber,
        ?string $status = null,
        ?array $similarAccountNumbers = null
    ): string {
        $status = $status ? ' '.$status : '';
        $accountNumbers = '';
        if ($similarAccountNumbers) {
            $accountNumbers = array_map(static fn ($accountNumber) => $accountNumber->toString(), $similarAccountNumbers);
            sort($accountNumbers);
            $accountNumbers = array_map(static fn ($accountNumber) => sprintf("'%s'", $accountNumber), $accountNumbers);
            $accountNumbers = sprintf(' [%s]', implode(', ', $accountNumbers));
        }

        return $accountNumber->toString().$status.$accountNumbers.PHP_EOL;
    }
}
