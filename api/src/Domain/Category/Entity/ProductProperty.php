<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity;

use App\Domain\Category\Entity\Category\Category;
use App\Domain\Common\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'category_product_properties')]
class ProductProperty
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\ManyToOne(targetEntity: Category::class)]
	#[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
	private Category $category;

	#[ORM\Column(type: "text", length: 255)]
	private string $name;
}