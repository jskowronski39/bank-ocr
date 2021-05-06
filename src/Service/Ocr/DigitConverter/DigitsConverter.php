<?php

declare(strict_types=1);

namespace App\Service\Ocr\DigitConverter;

use App\Service\Ocr\DigitConverter\Exception\ConversionException;
use App\Service\Ocr\Enum\DigitMappingEnum;

class DigitsConverter implements DigitsConverterInterface
{
    private const KEY_INTEGER = 'integer';
    private const KEY_ARRAY = 'array';

    public function convertToInteger(array $digitAsArray): int
    {
        foreach (DigitMappingEnum::getValues() as $mappedDigit) {
            if ($mappedDigit[self::KEY_ARRAY] === $digitAsArray) {
                return $mappedDigit[self::KEY_INTEGER];
            }
        }

        throw new ConversionException('Cannot convert array to integer');
    }
}
