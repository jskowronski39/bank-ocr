<?php

declare(strict_types=1);

namespace App\Service\Ocr\Validator;

use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\Validator\Exception\InvalidNumberFormatException;

interface ValidatorInterface
{
    /**
     * @throws InvalidNumberFormatException
     */
    public function isChecksumValid(AccountNumberInterface $accountNumber): bool;
}
