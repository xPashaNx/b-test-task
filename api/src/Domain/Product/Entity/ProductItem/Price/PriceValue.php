<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\ProductItem\Price;

class PriceValue
{
	private float $value;

	public function __construct(float $value)
	{
		$this->value = $value;
	}

	public function getValue(): float
	{
		return $this->value;
	}
}