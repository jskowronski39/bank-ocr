<?php

declare(strict_types=1);

namespace App\Service\Ocr\DigitConverter;

use App\Service\Ocr\DigitConverter\Exception\ConversionException;

interface DigitsConverterInterface
{
    /**
     * @throws ConversionException
     */
    public function convertToInteger(array $digitAsArray): int;
}
