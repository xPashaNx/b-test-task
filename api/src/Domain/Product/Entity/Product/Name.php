<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\Product;

use Webmozart\Assert\Assert;

class Name
{
	private string $value;

	public function __construct(string $value)
	{
		$this->value = trim($value);
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