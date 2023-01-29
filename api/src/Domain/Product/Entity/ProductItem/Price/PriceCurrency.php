<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\ProductItem\Price;

class PriceCurrency
{
	private string $currency;

	public function __construct(string $currency)
	{
		$this->currency = $currency;
	}

	public function getCurrency(): string
	{
		return $this->currency;
	}
}