<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	#[Route('/', name: 'index', methods: 'GET')]
	public function index(): Response
	{
		return $this->json([
			'name' => 'App API',
			'version' => '1.0',
		]);
	}
}