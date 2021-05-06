<?php

declare(strict_types=1);

namespace App\Service\Ocr\Validator;

use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\Validator\Exception\InvalidNumberFormatException;

class Validator implements ValidatorInterface
{
    private const REGEX_PATTERN = '~^[\d]{9}$~';
    private const INDEX_OFFSET = 1;
    private const MODULO_DIVISOR = 11;

    public function isChecksumValid(AccountNumberInterface $accountNumber): bool
    {
        $number = $accountNumber->toString();
        if (1 !== preg_match(self::REGEX_PATTERN, $number)) {
            throw new InvalidNumberFormatException(
                sprintf('Invalid number "%s" given. Number must consist of 9 digits from range 0-9', $number)
            );
        }

        $sum = 0;
        $digits = str_split($number);
        $reversedDigits = array_reverse($digits);

        foreach ($reversedDigits as $index => $digit) {
            $multiplier = $index + self::INDEX_OFFSET;
            $sum += $multiplier * (int) $digit;
        }

        return ($sum % self::MODULO_DIVISOR) === 0;
    }
}
