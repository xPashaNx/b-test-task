<?php

declare(strict_types=1);

namespace App\Domain\Product\ValueObject\ProductProperty;

use App\Domain\Category\Entity\ProductProperty;
use Webmozart\Assert\Assert;

class VariantProperty extends AbstractProductProperty
{
	private array $variants = [
		'xs', 's', 'm', 'l', 'xl', 'xxl', 'xxxl',
	];

	public function __construct(ProductProperty $property, $value)
	{
		$value = strtolower(trim($value));

		Assert::stringNotEmpty($value);
		Assert::oneOf($value, $this->variants);

		parent::__construct($property, $value);
	}

	static public function getName(): string
	{
		return 'variant';
	}
}