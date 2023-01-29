<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Product\UseCase\CreateOrUpdatePrice\CreateOrUpdatePriceCommand;
use App\Domain\Product\UseCase\CreateOrUpdatePrice\CreateOrUpdatePriceHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
	public function __construct(
		private SerializerInterface $serializer,
		private ValidatorInterface $validator,
		private CreateOrUpdatePriceHandler $handler,
	)
	{
	}

	#[Route('/product/price', name: 'upsert_price', methods: 'POST')]
	public function createOrUpdatePrice(Request $request): Response
	{
		try {
			$command = $this->serializer->deserialize(
				json_encode($request->toArray()),
				CreateOrUpdatePriceCommand::class,
				'json'
			);

			$errors = $this->validator->validate($command);
			if (count($errors)) {
				return $this->json(['error' => $errors]);
			}

			$this->handler->handle($command);

			return $this->json(['status' => 'success']);
		} catch (Exception $e) {
			return $this->json(['error' => $e->getMessage()]);
		}
	}
}