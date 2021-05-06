<?php

declare(strict_types=1);

namespace App\Service\Ocr\Model;

interface DigitInterface
{
    public function getAsArray(): array;

    public function getAsString(): string;

    public function isIllegible(): bool;
}
