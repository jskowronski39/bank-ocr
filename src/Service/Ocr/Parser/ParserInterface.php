<?php

declare(strict_types=1);

namespace App\Service\Ocr\Parser;

use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\Validator\Exception\InvalidNumberFormatException;

interface ParserInterface
{
    /**
     * @throws InvalidNumberFormatException
     */
    public function parse(string $numberAsString): AccountNumberInterface;
}
