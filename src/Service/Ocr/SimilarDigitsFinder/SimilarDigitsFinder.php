<?php

declare(strict_types=1);

namespace App\Service\Ocr\SimilarDigitsFinder;

use App\Service\Ocr\DigitConverter\DigitsConverterInterface;
use App\Service\Ocr\Enum\DigitMappingEnum;
use App\Service\Ocr\Model\Digit;
use App\Service\Ocr\Model\DigitInterface;

class SimilarDigitsFinder implements SimilarDigitsFinderInterface
{
    private const KEY_ARRAY = 'array';

    private DigitsConverterInterface $digitsConverter;
    private int $allowedCharacterDifference;

    public function __construct(
        DigitsConverterInterface $digitsConverter,
        int $allowedCharacterDifference = 1
    ) {
        $this->digitsConverter = $digitsConverter;
        $this->allowedCharacterDifference = $allowedCharacterDifference;
    }

    public function findSimilarDigits(DigitInterface $digit): array
    {
        $similarDigits = [];

        foreach (DigitMappingEnum::getValues() as $digitMapping) {
            $digitAsArray = $digitMapping[self::KEY_ARRAY];
            $characterDifferenceCount = $this->getCharacterDifferenceCount(
                $digit->getAsArray(),
                $digitAsArray
            );

            if ($characterDifferenceCount === $this->allowedCharacterDifference) {
                $digitAsString = (string) $this->digitsConverter->convertToInteger($digitAsArray);
                $similarDigits[] = new Digit($digitAsArray, $digitAsString, false);
            }
        }

        return $similarDigits;
    }

    private function getCharacterDifferenceCount(array $digitAsArray, array $digitAsArrayToCompare): int
    {
        $characterDifferenceCount = 0;

        foreach ($digitAsArray as $rowIndex => $row) {
            foreach ($row as $columnIndex => $column) {
                if ($column !== $digitAsArrayToCompare[$rowIndex][$columnIndex]) {
                    ++$characterDifferenceCount;
                }
            }
        }

        return $characterDifferenceCount;
    }
}
