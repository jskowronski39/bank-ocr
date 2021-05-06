<?php

declare(strict_types=1);

namespace App\Tests\Service\Ocr\Validator;

use App\Service\Ocr\Model\AccountNumberInterface;
use App\Service\Ocr\Validator\Exception\InvalidNumberFormatException;
use App\Service\Ocr\Validator\Validator;
use App\Service\Ocr\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \App\Service\Ocr\Validator\Validator
 */
final class ValidatorTest extends TestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new Validator();
    }

    /**
     * @test
     * @dataProvider numbersInInvalidFormatsDataSource
     */
    public function throws_invalid_number_format_exception(string $number): void
    {
        $this->expectException(InvalidNumberFormatException::class);
        $this->expectExceptionMessage(
            sprintf('Invalid number "%s" given. Number must consist of 9 digits from range 0-9', $number)
        );

        $accountNumber = $this->createMock(AccountNumberInterface::class);
        $accountNumber->method('toString')->willReturn($number);

        $this->validator->isChecksumValid($accountNumber);
    }

    /**
     * @test
     * @dataProvider numbersWithValidChecksumDataSource
     */
    public function returns_true_when_number_checksum_valid(string $number): void
    {
        $accountNumber = $this->createMock(AccountNumberInterface::class);
        $accountNumber->method('toString')->willReturn($number);

        $result = $this->validator->isChecksumValid($accountNumber);

        static::assertTrue($result);
    }

    /**
     * @test
     * @dataProvider numbersWithInvalidChecksumDataSource
     */
    public function returns_false_when_number_checksum_invalid(string $number): void
    {
        $accountNumber = $this->createMock(AccountNumberInterface::class);
        $accountNumber->method('toString')->willReturn($number);

        $result = $this->validator->isChecksumValid($accountNumber);

        static::assertFalse($result);
    }

    public function numbersInInvalidFormatsDataSource(): array
    {
        return [
            ['123'],
            ['asd'],
            ['   '],
        ];
    }

    public function numbersWithValidChecksumDataSource(): array
    {
        return [
            ['123456789'],
            ['457508000'],
            ['000000051'],
        ];
    }

    public function numbersWithInvalidChecksumDataSource(): array
    {
        return [
            ['111111111'],
            ['222222222'],
            ['333333333'],
        ];
    }
}
