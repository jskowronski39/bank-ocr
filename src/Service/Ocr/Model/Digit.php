<?php

declare(strict_types=1);

namespace App\Service\Ocr\Model;

class Digit implements DigitInterface
{
    private array $asArray;
    private string $asString;
    private bool $illegible;

    public function __construct(array $asArray, string $asString, bool $illegible)
    {
        $this->asArray = $asArray;
        $this->asString = $asString;
        $this->illegible = $illegible;
    }

    public function getAsArray(): array
    {
        return $this->asArray;
    }

    public function getAsString(): string
    {
        return $this->asString;
    }

    public function isIllegible(): bool
    {
        return $this->illegible;
    }
}
