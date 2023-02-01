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
    #[Route('/', name: 'Acceuil')]
    public function Acceuil(): Response
    {
        return new Response('20 STP');
    }
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
        try {

            $product = new Cinema();

            $product->setNom('Avatar 2');
            $product->setSynopsis('Tout bleu');
            $product->setType('');
            $dateObject = new DateTime();

            $product->setCreatedAt($dateObject);
            $entityManager->persist($product);

            $entityManager->flush();
        } catch (\Exception $ex) {
            return new JsonResponse(["error" => true], 500);
        }

        return new JsonResponse(array(
            'Httpcode' => '200',
            'message' => 'Insertion réusite'
        ));
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
        if (!$products) {
            return new JsonResponse(array(
                'Httpcode' => '204'
            ));
        } else {
        }
        $cinema = array();
        $cinema[] = array(
            'id' => $products->getId(),
            'nom' => $products->getNom(),
            'synopsis' => $products->getSynopsis(),
            'type' => $products->getType(),
            'created_at' => $products->getCreatedAt()
        );


        return new JsonResponse(array(
            'Httpcode' => '200',
            'Content' => $cinema,
        ));
    }
}
