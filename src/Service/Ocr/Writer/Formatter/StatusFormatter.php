<?php

declare(strict_types=1);

namespace App\Service\Ocr\Writer\Formatter;

use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\Validator\ValidatorInterface;

class StatusFormatter implements FormatterInterface
{
    private ValidatorInterface $validator;
    private string $illegibleStatus;
    private string $invalidChecksumStatus;

    public function __construct(
        ValidatorInterface $validator,
        string $illegibleStatus,
        string $invalidChecksumStatus
    ) {
        $this->validator = $validator;
        $this->illegibleStatus = $illegibleStatus;
        $this->invalidChecksumStatus = $invalidChecksumStatus;
    }

    public function formatAccountNumberLine(AccountNumberInterface $accountNumber): string
    {
        $status = '';
        if ($accountNumber->containsIllegibleDigits()) {
            $status = ' '.$this->illegibleStatus;
        } elseif (!$this->validator->isChecksumValid($accountNumber)) {
            $status = ' '.$this->invalidChecksumStatus;
        }

        return $accountNumber->toString().$status.PHP_EOL;
    }
}
