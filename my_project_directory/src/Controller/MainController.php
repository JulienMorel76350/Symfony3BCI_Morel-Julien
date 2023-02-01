<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cinema;
use App\Repository\CinemaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/create', name: 'Crée')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Cinema();

        $product->setNom('Avatar 2');
        $product->setSynopsis('Tout bleu');
        $product->setType('Film');
        $dateObject = new DateTime();

        $product->setCreatedAt($dateObject);
        $entityManager->persist($product);

        $entityManager->flush();

        return new Response('Saved new product');
    }
    #[Route('/getall', name: 'Tout récuperer')]
    public function getall(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Cinema::class);
        $products = $repository->findAll();

        foreach ($products as $value) {
            $cinema[] = array(
                'id' => $value->getId(),
                'nom' => $value->getNom(),
                'synopsis' => $value->getSynopsis(),
                'type' => $value->getType(),
                'created_at' => $value->getCreatedAt()
            );
        }
        return new JsonResponse($cinema);
    }
    #[Route('/get/{param}', name: 'homepage')]
    public function getOneByIdItem(ManagerRegistry $doctrine, int $param): Response
    {
        $repository = $doctrine->getRepository(Cinema::class);
        $products = $repository->findOneById($param);
        $cinema = array();
        $cinema[] = array(
            'id' => $products->getId(),
            'nom' => $products->getNom(),
            'synopsis' => $products->getSynopsis(),
            'type' => $products->getType(),
            'created_at' => $products->getCreatedAt()
        );


        return new JsonResponse($cinema);
    }
}
