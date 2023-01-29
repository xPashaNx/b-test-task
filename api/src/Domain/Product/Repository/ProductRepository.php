<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Product\Entity\Product\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DomainException;

class ProductRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Product::class);
	}

	/**
	 * @param string $name
	 * @throws DomainException
	 * @return Product
	 */
	public function getByName(string $name): Product
	{
		$product = $this->findOneBy(['name' => $name]);
		if (!$product) {
			throw new DomainException("Product not found.");
		}

		return $product;
	}
}