<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Service\ProductManager;
use App\Service\CategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
	private ProductManager $productManager;
	private CategoryManager $categoryManager;

	public function __construct(ProductManager $productManager, CategoryManager $categoryManager)
	{
		$this->productManager = $productManager;
		$this->categoryManager = $categoryManager;
	}

	#[Route('', name: 'app_home')]
	public function index(): Response
	{
		return $this->render('shop/index.html.twig', [
			'featured_products' => $this->productManager->getFeatured(),
			'categories' => $this->categoryManager->findAll(),
		]);
	}
}
