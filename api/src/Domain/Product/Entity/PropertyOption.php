<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity;

use App\Domain\Category\Entity\ProductProperty;
use App\Domain\Common\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'product_property_options')]
class PropertyOption
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\ManyToOne(targetEntity: ProductProperty::class)]
	#[ORM\JoinColumn(name: 'property_id', referencedColumnName: 'id')]
	private ProductProperty $property;

	#[ORM\Column(type: "text", length: 255)]
	private string $value;

	public function __construct(ProductProperty $property, string $value)
	{
		$this->id = Uuid::generate();
		$this->property = $property;
		$this->value = $value;

		Assert::notEmpty($value);
	}
}