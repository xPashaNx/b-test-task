<?php

declare(strict_types=1);

namespace App\Domain\Product\ValueObject\ProductProperty;

use App\Domain\Category\Entity\ProductProperty;
use Webmozart\Assert\Assert;

class LengthProperty extends AbstractProductProperty
{
	public function __construct(ProductProperty $property, $value)
	{
		Assert::integer($value);
		Assert::greaterThan($value, 0);

		parent::__construct($property, $value);
	}

	static public function getName(): string
	{
		return 'length';
	}
}