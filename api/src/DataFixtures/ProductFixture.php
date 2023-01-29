<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Domain\Category\Entity\Category\Category;
use App\Domain\Product\Entity\Product\Name;
use App\Domain\Product\Entity\Product\Product;
use App\Domain\Product\Entity\ProductItem\Price\Price;
use App\Domain\Product\Entity\ProductItem\Price\PriceCurrency;
use App\Domain\Product\Entity\ProductItem\Price\PriceValue;
use App\Domain\Product\Entity\ProductItem\ProductItem;
use App\Domain\Product\Service\ProductPropertyCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture implements DependentFixtureInterface
{
	private array $products = [
		[
			'name' => 'Shoes 1',
			'categoryReference' => CategoryFixture::SHOES_REFERENCE,
			'items' => [],
		],
		[
			'name' => 'Shoes 2',
			'categoryReference' => CategoryFixture::SHOES_REFERENCE,
			'items' => [
				[
					'price' => ['value' => 50, 'currency' => 'usd'],
					'properties' => ['size' => 38],
				],
				[
					'price' => ['value' => 50, 'currency' => 'usd'],
					'properties' => ['size' => 41],
				],
			],
		],
		[
			'name' => 'Clothes 1',
			'categoryReference' => CategoryFixture::CLOTHES_REFERENCE,
			'items' => [
				[
					'price' => ['value' => 80, 'currency' => 'eur'],
					'properties' => ['variant' => 'm'],
				],
				[
					'price' => ['value' => 80, 'currency' => 'eur'],
					'properties' => ['variant' => 'xl'],
				],
			],
		],
		[
			'name' => 'Jewelry 1',
			'categoryReference' => CategoryFixture::JEWELRY_REFERENCE,
			'items' => [
				[
					'price' => ['value' => 100, 'currency' => 'eur'],
					'properties' => ['length' => 100],
				],
				[
					'price' => ['value' => 150, 'currency' => 'eur'],
					'properties' => ['length' => 150],
				],
			],
		],
	];

	public function load(ObjectManager $manager)
	{
		$productPropertyCreator = new ProductPropertyCreator();

		foreach ($this->products as $product) {
			$category = $this->getReference($product['categoryReference']);
			if ($category instanceof Category) {
				$productEntity = new Product(
					new Name($product['name']),
					$category
				);

				foreach ($product['items'] as $productItem) {
					$productProperties = [];
					foreach ($productItem['properties'] as $propertyName => $propertyValue) {
						$productProperties[] = $productPropertyCreator->create(
							$category->getProductProperty($propertyName),
							$propertyValue
						);
					}

					$productItem = new ProductItem(
						$productEntity,
						new Price(
							new PriceValue($productItem['price']['value']),
							new PriceCurrency($productItem['price']['currency'])
						),
						$productProperties
					);

					$productEntity->addOrUpdateProductItem($productItem, $category->getPriceProperties());
				}

				$manager->persist($productEntity);
			}
		}

		$manager->flush();
	}

	public function getDependencies(): array
	{
		return [
			CategoryFixture::class,
		];
	}
}