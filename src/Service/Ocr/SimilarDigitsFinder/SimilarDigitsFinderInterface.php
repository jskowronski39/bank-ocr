<?php

declare(strict_types=1);

namespace App\Service\Ocr\SimilarDigitsFinder;

use App\Service\Ocr\Model\DigitInterface;

interface SimilarDigitsFinderInterface
{
    public function findSimilarDigits(DigitInterface $digit): array;
}
