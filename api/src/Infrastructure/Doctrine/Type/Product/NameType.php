<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Product;

use App\Domain\Product\Entity\Product\Name;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class NameType extends StringType
{
	public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
	{
		return $value instanceof Name ? $value->getValue() : $value;
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): ?Name
	{
		return !empty($value) ? new Name((string)$value) : null;
	}
}