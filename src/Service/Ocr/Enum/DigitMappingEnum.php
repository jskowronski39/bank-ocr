<?php

declare(strict_types=1);

namespace App\Service\Ocr\Enum;

class DigitMappingEnum
{
    public const ZERO = [
        'integer' => 0,
        'array' => [
            [' ', '_', ' '],
            ['|', ' ', '|'],
            ['|', '_', '|'],
        ],
    ];

    public const ONE = [
        'integer' => 1,
        'array' => [
            [' ', ' ', ' '],
            [' ', ' ', '|'],
            [' ', ' ', '|'],
        ],
    ];

    public const TWO = [
        'integer' => 2,
        'array' => [
            [' ', '_', ' '],
            [' ', '_', '|'],
            ['|', '_', ' '],
        ],
    ];

    public const THREE = [
        'integer' => 3,
        'array' => [
            [' ', '_', ' '],
            [' ', '_', '|'],
            [' ', '_', '|'],
        ],
    ];

    public const FOUR = [
        'integer' => 4,
        'array' => [
            [' ', ' ', ' '],
            ['|', '_', '|'],
            [' ', ' ', '|'],
        ],
    ];

    public const FIVE = [
        'integer' => 5,
        'array' => [
            [' ', '_', ' '],
            ['|', '_', ' '],
            [' ', '_', '|'],
        ],
    ];

    public const SIX = [
        'integer' => 6,
        'array' => [
            [' ', '_', ' '],
            ['|', '_', ' '],
            ['|', '_', '|'],
        ],
    ];

    public const SEVEN = [
        'integer' => 7,
        'array' => [
            [' ', '_', ' '],
            [' ', ' ', '|'],
            [' ', ' ', '|'],
        ],
    ];

    public const EIGHT = [
        'integer' => 8,
        'array' => [
            [' ', '_', ' '],
            ['|', '_', '|'],
            ['|', '_', '|'],
        ],
    ];

    public const NINE = [
        'integer' => 9,
        'array' => [
            [' ', '_', ' '],
            ['|', '_', '|'],
            [' ', '_', '|'],
        ],
    ];

    public static function getValues(): array
    {
        $reflection = new \ReflectionClass(static::class);

        return $reflection->getConstants();
    }
}
