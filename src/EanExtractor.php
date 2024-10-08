<?php

declare(strict_types=1);

namespace Lucasnpinheiro\Ean;

use InvalidArgumentException;
use stdClass;

class EanExtractor
{
    private string $code = '';
    private string $value = '';

    public function __construct(private string $eanCode = '')
    {
        $this->eanCode = preg_replace('/\D/', '', $eanCode);

        if (empty($this->eanCode)) {
            throw new InvalidArgumentException('EAN code cannot be empty');
        }

        $this->code = $this->eanCode;
    }

    public function toObject(): stdClass
    {
        return (object)$this->toArray();
    }

    public function toArray(): array
    {
        return [
            'ean_code' => $this->eanCode(),
            'scale_product' => $this->isScaleProduct(),
            'international_number' => $this->hasInternationalNumber(),
            'custom_code_999' => $this->isCustomCode999(),
            'custom_code_2' => $this->isCustomCode2(),
            'code' => $this->code(),
            'value' => $this->value(),
        ];
    }

    public function eanCode(): string
    {
        return $this->eanCode;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function value(): string{
        return $this->value;
    }

    public function isScaleProduct(): bool
    {
        $firstDigit = $this->eanCode[0];

        if (strlen($this->eanCode) === 7 && $firstDigit === '9') {
            $this->code = $this->eanCode;
            return true;
        }
        return false;
    }

    public function hasInternationalNumber(): bool
    {
        return strlen($this->eanCode) === 11;
    }

    public function isCustomCode999(): bool
    {
        $firstThreeDigits = substr($this->eanCode, 0, 3);

        if (strlen($this->eanCode) === 13 && $firstThreeDigits === '999') {
            $this->code = substr($this->eanCode, 0, 12);
            return true;
        }
        return false;
    }

    public function isCustomCode2(): bool
    {
        $firstDigit = $this->eanCode[0];

        if (strlen($this->eanCode) === 13 && $firstDigit === '2') {
            $this->code = substr($this->eanCode, 1, 5);
            $this->value = substr($this->eanCode, 6, 6);
            return true;
        }
        return false;
    }
}
