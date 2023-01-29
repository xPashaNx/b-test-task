<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\ProductItem\Price;

use Webmozart\Assert\Assert;

class PriceValue
{
	private float $value;

	public function __construct(float $value)
	{
		$this->value = $value;

		Assert::float($this->value);
		Assert::greaterThan($this->value, 0);
	}

	public function getValue(): float
	{
		return $this->value;
	}
}