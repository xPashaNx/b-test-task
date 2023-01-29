<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity\Category;

use App\Domain\Category\Entity\PriceProperty;
use App\Domain\Category\Entity\ProductProperty;
use App\Domain\Common\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'categories')]
class Category
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\Column(type: "category_sysname", length: 255, unique: true)]
	private Sysname $sysname;

	#[ORM\Column(type: "text", length: 255)]
	private string $title;

	#[ORM\OneToMany(mappedBy: "category", targetEntity: ProductProperty::class, cascade: ["persist"])]
	private Collection $productProperties;

	#[ORM\OneToMany(mappedBy: "category", targetEntity: PriceProperty::class, cascade: ["persist"])]
	private Collection $priceProperties;

	public function __construct(Sysname $sysname, string $title)
	{
		Assert::stringNotEmpty($title);

		$this->id = Uuid::generate();
		$this->sysname = $sysname;
		$this->title = $title;
		$this->productProperties = new ArrayCollection();
		$this->priceProperties = new ArrayCollection();
	}

	public function getProductProperty(string $property): ProductProperty
	{
		$properties = $this->productProperties->filter(
			fn(ProductProperty $productProperty) => $productProperty->isEqualTo($property)
		)->toArray();

		if (empty($properties)) {
			throw new DomainException("ProductProperty ($property) is not found.");
		}

		return $properties[0];
	}

	/**
	 * @return PriceProperty[]
	 */
	public function getPriceProperties(): array
	{
		return $this->priceProperties->toArray();
	}

	public function addProductProperty(ProductProperty $property): void
	{
		if (!$this->productProperties->contains($property)) {
			$this->productProperties->add($property);
		}
	}

	public function addPriceProperty(PriceProperty $property): void
	{
		if (!$this->priceProperties->contains($property)) {
			$this->priceProperties->add($property);
		}
	}
}