<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity\Category;

class Sysname
{
	private string $value;

	public function __construct(string $value)
	{
		$this->value = strtolower(trim($value));
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function __toString(): string
	{
		return $this->getValue();
	}
}