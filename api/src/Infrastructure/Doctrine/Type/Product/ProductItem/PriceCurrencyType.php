<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Product\ProductItem;

use App\Domain\Product\Entity\ProductItem\Price\PriceCurrency;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class PriceCurrencyType extends StringType
{
	public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
	{
		return $value instanceof PriceCurrency ? $value->getCurrency() : $value;
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): ?PriceCurrency
	{
		return !empty($value) ? new PriceCurrency((string)$value) : null;
	}
}