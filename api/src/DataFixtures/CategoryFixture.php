<?php

namespace App\DataFixtures;

use App\Domain\Category\Entity\Category\Category;
use App\Domain\Category\Entity\Category\Sysname;
use App\Domain\Category\Entity\PriceProperty;
use App\Domain\Category\Entity\ProductProperty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
	public const SHOES_REFERENCE = 'shoes';
	public const CLOTHES_REFERENCE = 'clothes';
	public const JEWELRY_REFERENCE = 'jewelry';

	private array $categories = [
		[
			'sysname' => self::SHOES_REFERENCE,
			'title' => 'Shoes',
			'productProperties' => [
				'size'
			],
			'priceProperties' => [
			],
		],
		[
			'sysname' => self::CLOTHES_REFERENCE,
			'title' => 'Clothes',
			'productProperties' => [
				'variant'
			],
			'priceProperties' => [
			],
		],
		[
			'sysname' => self::JEWELRY_REFERENCE,
			'title' => 'Jewelry',
			'productProperties' => [
				'length'
			],
			'priceProperties' => [
				'length'
			],
		],
	];

    public function load(ObjectManager $manager): void
    {
	    foreach ($this->categories as $category) {
		    $categoryEntity = new Category(
				new Sysname($category['sysname']),
			    $category['title']
		    );

			if (!empty($category['productProperties'])) {
				foreach ($category['productProperties'] as $productProperty) {
					$categoryEntity->addProductProperty(new ProductProperty($productProperty, $categoryEntity));
				}
			}

			if (!empty($category['priceProperties'])) {
				foreach ($category['priceProperties'] as $priceProperty) {
					$categoryEntity->addPriceProperty(
						new PriceProperty($categoryEntity->getProductProperty($priceProperty))
					);
				}
			}

		    $manager->persist($categoryEntity);
			$this->addReference($category['sysname'], $categoryEntity);
		}

        $manager->flush();
    }
}
