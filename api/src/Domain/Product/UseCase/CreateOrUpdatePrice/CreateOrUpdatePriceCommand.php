<?php

declare(strict_types=1);

namespace App\Domain\Product\UseCase\CreateOrUpdatePrice;

use Symfony\Component\Validator\Constraints as Assert;

class CreateOrUpdatePriceCommand
{
	#[Assert\NotBlank, Assert\NotNull, Assert\Type("string")]
	private string $productName;

	#[Assert\Type("float"), Assert\NotBlank, Assert\NotNull, Assert\Range(min: 1)]
	private float $priceValue;

	#[Assert\NotBlank, Assert\NotNull, Assert\Type("string")]
	private string $priceCurrency;

	private array $properties;

	public function __construct(string $productName, float $priceValue, string $priceCurrency, array $properties)
	{
		$this->productName = $productName;
		$this->priceValue = $priceValue;
		$this->priceCurrency = $priceCurrency;
		$this->properties = $properties;
	}

	/**
	 * @return string
	 */
	public function getProductName(): string
	{
		return $this->productName;
	}

	/**
	 * @return float
	 */
	public function getPriceValue(): float
	{
		return $this->priceValue;
	}

	/**
	 * @return string
	 */
	public function getPriceCurrency(): string
	{
		return $this->priceCurrency;
	}

	/**
	 * @return array
	 */
	public function getProperties(): array
	{
		return $this->properties;
	}
}