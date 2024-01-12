<?php

namespace App\Controller;

use App\Entity\Allergen;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $manager): Response
    {
        // Listage de tous les allergènes
        $allergens = $manager->getRepository(Allergen::class)->findAll();

        // searchString juste pour faire marcher le template (à retirer)
        $searchString = '';

        return $this->render('pages/home/index.html.twig', [
            'allergens' => $allergens,
            'searchString' => $searchString,
        ]);
    }
}
