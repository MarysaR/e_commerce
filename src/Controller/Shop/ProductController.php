<?php

namespace App\Controller\Shop;

use App\Repository\ProductRepository;
use App\Service\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
	public function __construct(private readonly ProductManager $productManager)
	{
	}
	
	#[Route('/products', name: 'app_shop_products')]
    #[Route('/products/{category?}', name: 'app_shop_products', requirements: ['category' => '\d+'])]
    public function index(ProductRepository $productRepository, ?int $category): Response
    {
        return $this->render('shop/product/index.html.twig', [
            'products' => $productRepository->findAll(), //TODO Il faut remplacer le findAll par la méthode equivalente dans ProductManager pour filtrer les produits par la categorie, si nous avons une catégorie ,
	        'categories' => [] //TODO Il faut remplacer ce tableau par les categories venant de la base de données
        ]);
    }
	
	#[Route('/{id}-{slug}', name: 'app_shop_product_show', requirements: ['id' => '\d+'])]
	public function show(int $id, string $slug): Response
	{
		$product = $this->productManager->findById($id);
		
		if (!$product) {
			throw $this->createNotFoundException('Le produit n\'existe pas');
		}
		
		if ($product->getSlug() !== $slug) {
			return $this->redirectToRoute('app_shop_product_show', [
				'id' => $product->getId(),
				'slug' => $product->getSlug()
			], 301);
		}
		
		return $this->render('shop/product/show.html.twig', [
			'product' => $product,
			'similarProducts' => $this->productManager->getSimilars($product),
		]);
	}
}
