<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\ProductItem;

use App\Domain\Common\Entity\Uuid;
use App\Domain\Product\Entity\Product\Product;
use App\Domain\Product\Entity\ProductItem\Price\Price;
use App\Domain\Product\Entity\ProductItem\Price\PriceCurrency;
use App\Domain\Product\Entity\ProductItem\Price\PriceValue;
use App\Domain\Product\Entity\PropertyOption;
use App\Domain\Product\ValueObject\ProductProperty\AbstractProductProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_items')]
class ProductItem
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\ManyToOne(targetEntity: Product::class)]
	#[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
	private Product $product;

	#[ORM\Column(type: "product_item_price_value")]
	private PriceValue $priceValue;

	#[ORM\Column(type: "product_item_price_currency")]
	private PriceCurrency $priceCurrency;

	#[ORM\ManyToMany(targetEntity: PropertyOption::class, inversedBy: "product_items", cascade: ["persist"])]
	#[ORM\JoinTable(name: 'product_properties')]
	private Collection $propertyOptions;

	/**
	 * @param Product $product
	 * @param Price $price
	 * @param AbstractProductProperty[] $productProperties
	 */
	public function __construct(Product $product, Price $price, array $productProperties)
	{
		$this->id = Uuid::generate();
		$this->product = $product;
		$this->priceValue = $price->getValue();
		$this->priceCurrency = $price->getCurrency();

		$this->propertyOptions = new ArrayCollection();
		foreach ($productProperties as $productProperty) {
			$this->addPropertyOption(new PropertyOption(
				$productProperty->getProperty(),
				$productProperty->getValue()
			));
		}
	}

	/**
	 * @return PropertyOption[]
	 */
	public function getPropertyOptions(): array
	{
		return $this->propertyOptions->toArray();
	}

	public function getPrice(): Price
	{
		return new Price($this->priceValue, $this->priceCurrency);
	}

	public function setPrice(Price $price): void
	{
		$this->priceValue = $price->getValue();
		$this->priceCurrency = $price->getCurrency();
	}

	/**
	 * @param PropertyOption[] $options
	 * @return bool
	 */
	public function isSamePropertyOptions(array $options): bool
	{
		foreach ($options as $option) {
			foreach ($this->getPropertyOptions() as $currentOption) {
				if ($currentOption->getProperty()->isEqualTo($option->getProperty())) {
					if ($currentOption->getValue() !== $option->getValue()) {
						return false;
					}
				}
			}
		}

		return true;
	}

	private function addPropertyOption(PropertyOption $option): void
	{
		if (!$this->propertyOptions->contains($option)) {
			$this->propertyOptions->add($option);
		}
	}
}