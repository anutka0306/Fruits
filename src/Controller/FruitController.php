<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $fruits = $this->fruitRepository->findAll();
        $pagination = $this->paginator->paginate(
            $fruits,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('fruit/index.html.twig', [
            'fruits' => $fruits,
            'pagination' => $pagination
        ]);
    }

    #[Route('/api/getfruits', name: 'getfruits', methods: 'get')]
    public function getFruits(){
        $fruits = $this->fruitRepository->findAll();
        return $this->json([
            'fruits' => $fruits,
        ]);
    }
}
