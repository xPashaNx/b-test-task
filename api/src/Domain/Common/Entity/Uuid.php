<?php

declare(strict_types=1);

namespace App\Domain\Common\Entity;

use Symfony\Component\Uid\Uuid as UuidGenerator;
use Webmozart\Assert\Assert;

class Uuid
{
	private string $value;

	public function __construct(string $value)
	{
		$this->value = strtolower($value);
		Assert::uuid($this->value);
	}

	public static function generate(): self
	{
		return new self(UuidGenerator::v4()->toRfc4122());
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function __toString(): string
	{
		return $this->getValue();
	}

	public function isEqualTo($value): bool
	{
		if ($value instanceof self) {
			return $this->getValue() === $value->getValue();
		}

		return $this->getValue() === $value;
	}
}