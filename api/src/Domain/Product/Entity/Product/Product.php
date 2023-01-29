<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\Product;

use App\Domain\Category\Entity\Category\Category;
use App\Domain\Common\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\Column(type: "product_name")]
	private Name $name;

	#[ORM\ManyToOne(targetEntity: Category::class)]
	#[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
	private Category $category;
}