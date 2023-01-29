<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Product\ProductItem;

use App\Domain\Product\Entity\ProductItem\Price\PriceValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\FloatType;

class PriceValueType extends FloatType
{
	public function convertToDatabaseValue($value, AbstractPlatform $platform): ?float
	{
		return $value instanceof PriceValue ? $value->getValue() : $value;
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): ?PriceValue
	{
		return !empty($value) ? new PriceValue((float)$value) : null;
	}
}