<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\ProductItem\Price;

use Webmozart\Assert\Assert;

class PriceCurrency
{
	private const USD = 'usd';
	private const EUR = 'eur';
	private const GBP = 'gbp';

	private string $currency;

	private array $titles = [
		self::USD => 'USD',
		self::EUR => 'EUR',
		self::GBP => 'GBP',
	];

	public function __construct(string $currency)
	{
		$this->currency = strtolower(trim($currency));

		Assert::oneOf($currency, array_keys($this->titles));
	}

	public function getCurrency(): string
	{
		return $this->currency;
	}

	public function getTitle(): string
	{
		return $this->titles[$this->currency];
	}
}