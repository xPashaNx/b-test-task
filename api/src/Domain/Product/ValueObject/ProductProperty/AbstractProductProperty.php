<?php

declare(strict_types=1);

namespace App\Domain\Product\ValueObject\ProductProperty;

use App\Domain\Category\Entity\ProductProperty;
use DomainException;

abstract class AbstractProductProperty
{
	private ProductProperty $property;
	private mixed $value;

	public function __construct(ProductProperty $property, $value)
	{
		if (!$property->isEqualTo(static::getName())) {
			throw new DomainException("This property (" . static::getName() . ") does not much this ProductProperty (" . $property->getName() . ")");
		}

		$this->value = $value;
		$this->property = $property;
	}

	abstract static public function getName(): string;

	/**
	 * @return ProductProperty
	 */
	public function getProperty(): ProductProperty
	{
		return $this->property;
	}

	/**
	 * @return mixed
	 */
	public function getValue(): mixed
	{
		return $this->value;
	}
}