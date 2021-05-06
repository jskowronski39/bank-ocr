<?php

declare(strict_types=1);

namespace App\Service\Ocr\Model;

interface AccountNumberInterface
{
    /**
     * @return DigitInterface[]
     */
    public function getDigits(): array;

    public function containsIllegibleDigits(): bool;

    public function toString(): string;
}
