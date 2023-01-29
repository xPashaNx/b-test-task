<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity\ProductItem;

use App\Domain\Common\Uuid;
use App\Domain\Product\Entity\Product\Product;
use App\Domain\Product\Entity\ProductItem\Price\Price;
use App\Domain\Product\Entity\ProductItem\Price\PriceCurrency;
use App\Domain\Product\Entity\ProductItem\Price\PriceValue;
use App\Domain\Product\Entity\PropertyOption;
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

	public function __construct(Product $product, Price $price)
	{
		$this->id = Uuid::generate();
		$this->product = $product;
		$this->priceValue = $price->getValue();
		$this->priceCurrency = $price->getCurrency();
		$this->propertyOptions = new ArrayCollection();
	}

	public function addPropertyOption(PropertyOption $option): void
	{
		if (!$this->propertyOptions->contains($option)) {
			$this->propertyOptions->add($option);
		}
	}
}