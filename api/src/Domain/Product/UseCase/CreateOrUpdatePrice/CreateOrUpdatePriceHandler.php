<?php

declare(strict_types=1);

namespace App\Domain\Product\UseCase\CreateOrUpdatePrice;

use App\Domain\Product\Entity\ProductItem\Price\Price;
use App\Domain\Product\Entity\ProductItem\Price\PriceCurrency;
use App\Domain\Product\Entity\ProductItem\Price\PriceValue;
use App\Domain\Product\Entity\ProductItem\ProductItem;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Product\Service\ProductPropertyCreator;
use Doctrine\ORM\EntityManagerInterface;

class CreateOrUpdatePriceHandler
{
	public function __construct(
		private EntityManagerInterface $em,
		private ProductRepository $products,
		private ProductPropertyCreator $productPropertyCreator,
	)
	{
	}

	public function handle(CreateOrUpdatePriceCommand $command): void
	{
		$product = $this->products->getByName($command->getProductName());
		$category = $product->getCategory();

		$productProperties = [];
		foreach ($command->getProperties() as $propertyName => $propertyValue) {
			$productProperties[] = $this->productPropertyCreator->create(
				$category->getProductProperty($propertyName),
				$propertyValue
			);
		}

		$productItem = new ProductItem(
			$product,
			new Price(
				new PriceValue($command->getPriceValue()),
				new PriceCurrency($command->getPriceCurrency())
			),
			$productProperties
		);

		$product->addOrUpdateProductItem($productItem, $category->getPriceProperties());

		$this->em->persist($product);
		$this->em->flush();
	}
}