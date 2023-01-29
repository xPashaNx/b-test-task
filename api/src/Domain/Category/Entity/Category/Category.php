<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity\Category;

use App\Domain\Category\Entity\PriceProperty;
use App\Domain\Category\Entity\ProductProperty;
use App\Domain\Common\Uuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'categories')]
class Category
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\Column(type: "category_sysname", length: 255)]
	private Sysname $sysname;

	#[ORM\Column(type: "text", length: 255)]
	private string $title;

	#[ORM\OneToMany(mappedBy: "category", targetEntity: ProductProperty::class)]
	private Collection $productProperties;

	#[ORM\OneToMany(mappedBy: "category", targetEntity: PriceProperty::class)]
	private Collection $priceProperties;
}