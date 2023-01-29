<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity;

use App\Domain\Common\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'category_price_properties')]
class PriceProperty
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\ManyToOne(targetEntity: ProductProperty::class)]
	#[ORM\JoinColumn(name: 'property_id', referencedColumnName: 'id')]
	private ProductProperty $property;
}