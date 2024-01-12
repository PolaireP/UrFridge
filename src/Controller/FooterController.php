<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(): Response
    {
        return $this->render('footer/cgu.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }
}
