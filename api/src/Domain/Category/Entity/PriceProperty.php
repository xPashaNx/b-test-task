<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity;

use App\Domain\Category\Entity\Category\Category;
use App\Domain\Common\Entity\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'category_price_properties')]
class PriceProperty
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\ManyToOne(targetEntity: Category::class)]
	#[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
	private Category $category;

	#[ORM\ManyToOne(targetEntity: ProductProperty::class)]
	#[ORM\JoinColumn(name: 'property_id', referencedColumnName: 'id')]
	private ProductProperty $property;

	public function __construct(ProductProperty $property)
	{
		$this->id = Uuid::generate();
		$this->category = $property->getCategory();
		$this->property = $property;
	}

	/**
	 * @return ProductProperty
	 */
	public function getProperty(): ProductProperty
	{
		return $this->property;
	}
}