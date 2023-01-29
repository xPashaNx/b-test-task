<?php

declare(strict_types=1);

namespace App\Domain\Product\Service;

use App\Domain\Category\Entity\ProductProperty;
use App\Domain\Product\ValueObject\ProductProperty\AbstractProductProperty;
use App\Domain\Product\ValueObject\ProductProperty\LengthProperty;
use App\Domain\Product\ValueObject\ProductProperty\SizeProperty;
use App\Domain\Product\ValueObject\ProductProperty\VariantProperty;
use DomainException;

class ProductPropertyCreator
{
	private array $allowedProperties = [
		SizeProperty::class,
		LengthProperty::class,
		VariantProperty::class,
	];

	public function create(ProductProperty $property, $value): AbstractProductProperty
	{
		foreach ($this->allowedProperties as $allowedProperty) {
			if ($property->isEqualTo($allowedProperty::getName())) {
				return new $allowedProperty($property, $value);
			}
		}

		throw new DomainException("ProductProperty (" . $property->getName() . ") does not exist.");
	}
}