<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Common;

use App\Domain\Common\Entity\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UuidType extends GuidType
{
	public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
	{
		return $value instanceof Uuid ? $value->getValue(): $value;
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
	{
		return !empty($value) ? new Uuid((string)$value) : null;
	}

	public function requiresSQLCommentHint(AbstractPlatform $platform): bool
	{
		return true;
	}
}