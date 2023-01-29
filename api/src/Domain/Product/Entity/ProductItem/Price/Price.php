<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\ProductItem\Price;

class Price
{
	private PriceValue $value;
	private PriceCurrency $currency;

	public function __construct(PriceValue $value, PriceCurrency $currency)
	{
		$this->value = $value;
		$this->currency = $currency;
	}

	public function getValue(): PriceValue
	{
		return $this->value;
	}

	public function getCurrency(): PriceCurrency
	{
		return $this->currency;
	}

	public function __toString(): string
	{
		return implode(" ", [
			$this->getValue()->getValue(),
			$this->getCurrency()->getCurrency()
		]);
	}
}