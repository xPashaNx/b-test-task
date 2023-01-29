<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\Product;

use App\Domain\Category\Entity\Category\Category;
use App\Domain\Category\Entity\PriceProperty;
use App\Domain\Common\Entity\Uuid;
use App\Domain\Product\Entity\ProductItem\ProductItem;
use App\Domain\Product\Entity\PropertyOption;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

	#[ORM\OneToMany(mappedBy: "product", targetEntity: ProductItem::class, cascade: ["persist"], orphanRemoval: true)]
	private Collection $productItems;

	public function __construct(Name $name, Category $category)
	{
		$this->id = Uuid::generate();
		$this->name = $name;
		$this->category = $category;
		$this->productItems = new ArrayCollection();
	}

	/**
	 * @return Category
	 */
	public function getCategory(): Category
	{
		return $this->category;
	}

	/**
	 * @param ProductItem $item
	 * @param PriceProperty[] $priceProperties
	 * @return void
	 */
	public function addOrUpdateProductItem(ProductItem $item, array $priceProperties = []): void
	{
		if ($this->productItems->count() === 0) {
			$this->addProductItem($item);
			return;
		}

		if (empty($priceProperties)) {
			$this->getFirstProductItem()->update($item);
			return;
		}

		$isUpdated = $this->updateProductItem($item, $priceProperties);
		if (!$isUpdated) {
			$this->addProductItem($item);
		}
	}

	private function addProductItem(ProductItem $item): void
	{
		if (!$this->productItems->contains($item)) {
			$this->productItems->add($item);
		}
	}

	/**
	 * @param ProductItem $item
	 * @param PriceProperty[] $priceProperties
	 * @return bool
	 */
	private function updateProductItem(ProductItem $item, array $priceProperties): bool {
		$pricePropertyNames = array_map(
			fn(PriceProperty $property) => $property->getProperty()->getName(),
			$priceProperties
		);

		$propertyOptionsByPrice = array_filter(
			$item->getPropertyOptions(),
			fn(PropertyOption $option) => in_array($option->getProperty()->getName(), $pricePropertyNames)
		);

		if ($propertyOptionsByPrice) {
			foreach ($this->getProductItems() as $productItem) {
				if (!$productItem->isSamePropertyOptions($propertyOptionsByPrice)) {
					$productItem->update($item);
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @return ProductItem[]
	 */
	private function getProductItems(): array
	{
		return $this->productItems->toArray();
	}

	private function getFirstProductItem(): ProductItem
	{
		return $this->productItems->first();
	}
}