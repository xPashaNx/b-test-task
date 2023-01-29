<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity\Category;

use Webmozart\Assert\Assert;

class Sysname
{
	private string $value;

	public function __construct(string $value)
	{
		$this->value = strtolower(trim($value));
		Assert::stringNotEmpty($this->value);
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function __toString(): string
	{
		return $this->getValue();
	}
}