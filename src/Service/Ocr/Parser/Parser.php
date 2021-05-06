<?php

declare(strict_types=1);

namespace App\Service\Ocr\Parser;

use App\Service\Ocr\DigitConverter\DigitsConverterInterface;
use App\Service\Ocr\DigitConverter\Exception\ConversionException;
use App\Service\Ocr\Model\AccountNumber;
use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\Model\Digit;
use App\Service\Ocr\Validator\Exception\InvalidNumberFormatException;

class Parser implements ParserInterface
{
    private DigitsConverterInterface $digitsConverter;
    private string $illegibleCharacterToUse;
    private int $numberOfDigits;
    private int $rows;
    private int $columns;

    public function __construct(
        DigitsConverterInterface $digitsConverter,
        string $illegibleCharacterToUse,
        int $numberOfDigits,
        int $rows,
        int $columns
    ) {
        $this->digitsConverter = $digitsConverter;
        $this->illegibleCharacterToUse = $illegibleCharacterToUse;
        $this->numberOfDigits = $numberOfDigits;
        $this->rows = $rows;
        $this->columns = $columns;
    }

    public function parse(string $numberAsString): AccountNumberInterface
    {
        $characters = str_split($numberAsString);
        $charactersCount = \count($characters);
        $expectedCharactersCount = $this->numberOfDigits * $this->rows * $this->columns;

        if ($charactersCount !== $expectedCharactersCount) {
            throw new InvalidNumberFormatException(
                sprintf(
                    'Invalid number of characters. Expected "%s", "%s" given',
                    $expectedCharactersCount,
                    $charactersCount
                )
            );
        }

        $digits = [];
        foreach ($this->getDigitsAsArrays($characters) as $digitAsArray) {
            $isIllegible = false;

            try {
                $digitAsString = (string) $this->digitsConverter->convertToInteger($digitAsArray);
            } catch (ConversionException $ex) {
                $digitAsString = $this->illegibleCharacterToUse;
                $isIllegible = true;
            }

            $digits[] = new Digit($digitAsArray, $digitAsString, $isIllegible);
        }

        return new AccountNumber($digits);
    }

    private function getDigitsAsArrays(array $characters): array
    {
        $index = 0;
        $numbers = [];
        for ($r = 0; $r <= $this->rows - 1; ++$r) {
            for ($d = 0; $d <= $this->numberOfDigits - 1; ++$d) {
                for ($c = 0; $c <= $this->columns - 1; ++$c) {
                    $numbers[$d][$r][$c] = $characters[$index];
                    ++$index;
                }
            }
        }

        return $numbers;
    }
}
