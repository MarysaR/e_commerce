<?php
	
	namespace App\Controller;
	
	use App\Entity\Product;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Attribute\Route;
	
	class HomeController extends AbstractController
	{
		
		#[Route('', name: 'app_home')]
		public function index(): Response
		{
			return $this->render('shop/index.html.twig', [
				'featured_products' => [], // TODO : il faut injecter le bon service et appeler la methode pour recuperer les données
				'categories' => [] // TODO : il faut injecter le bon service et appeler la methode pour recuperer les données
			]);
		}
	}
