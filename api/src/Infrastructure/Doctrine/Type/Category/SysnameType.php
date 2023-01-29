<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Category;

use App\Domain\Category\Entity\Category\Sysname;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class SysnameType extends StringType
{
	public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
	{
		return $value instanceof Sysname ? $value->getValue() : $value;
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): ?Sysname
	{
		return !empty($value) ? new Sysname((string)$value) : null;
	}
}