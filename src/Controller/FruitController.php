<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FruitRepository;
use Knp\Component\Pager\PaginatorInterface;

class FruitController extends AbstractController
{
    protected FruitRepository $fruitRepository;
    protected PaginatorInterface $paginator;

    public function __construct(FruitRepository $fruitRepository, PaginatorInterface $paginator) {
        $this->fruitRepository = $fruitRepository;
        $this->paginator = $paginator;
    }

    #[Route('/', name: 'app_fruit')]
    public function index(Request $request): Response
    {
        return $this->render('fruit/index.html.twig');
    }

    #[Route('/favorite', name: 'app_favorite')]
    public function favorite(Request $request):Response
    {
     return $this->render('fruit/favorite.html.twig');
    }

    #[Route('/api/getfruits', name: 'getfruits', methods: 'get')]
    public function getFruits(): JsonResponse
    {
        $fruits = $this->fruitRepository->findAll();
        $families = $this->fruitRepository->getFamilies();
        return $this->json([
            'fruits' => $fruits,
            'families' => $families,
        ]);
    }

    #[Route('api/getfavorites', name: 'getFavorites', methods: 'get')]
    public function getFruitsByIds(Request $request):JsonResponse
    {
        $favorites = $this->fruitRepository->getFruitsByIds($request->get('fruits'));
        return $this->json([
           'favorites' => $favorites,
        ]);
    }
}
