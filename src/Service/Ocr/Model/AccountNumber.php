<?php

declare(strict_types=1);

namespace App\Service\Ocr\Model;

class AccountNumber implements AccountNumberInterface
{
    private array $digits;

    public function __construct(array $digits)
    {
        $this->digits = $digits;
    }

    /**
     * @return DigitInterface[]
     */
    public function getDigits(): array
    {
        return $this->digits;
    }

    public function containsIllegibleDigits(): bool
    {
        foreach ($this->getDigits() as $digit) {
            if ($digit->isIllegible()) {
                return true;
            }
        }

        return false;
    }

    public function toString(): string
    {
        $number = '';
        foreach ($this->getDigits() as $digit) {
            $number .= $digit->getAsString();
        }

        return $number;
    }
}
