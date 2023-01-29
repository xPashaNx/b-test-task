<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity;

use App\Domain\Category\Entity\Category\Category;
use App\Domain\Common\Entity\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'category_product_properties')]
class ProductProperty
{
	#[ORM\Id, ORM\Column(type: "uuid", unique: true)]
	private Uuid $id;

	#[ORM\ManyToOne(targetEntity: Category::class, inversedBy: "product_properties")]
	#[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
	private Category $category;

	#[ORM\Column(type: "text", length: 255)]
	private string $name;

	public function __construct(string $name, Category $category)
	{
		$this->id = Uuid::generate();
		$this->name = strtolower(trim($name));
		$this->category = $category;

		Assert::stringNotEmpty($this->name);
	}

	/**
	 * @return Category
	 */
	public function getCategory(): Category
	{
		return $this->category;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function isEqualTo($property): bool
	{
		if ($property instanceof self) {
			return $this->getName() === $property->getName();
		}

		return $this->getName() === $property;
	}
}