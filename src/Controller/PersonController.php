<?php

namespace App\Controller;

use App\Entity\PersonPhoto;
use App\Repository\PersonPhotoRepository;
use App\Repository\PersonRepository;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Zenstruck\Foundry\repository;

class PersonController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(PersonRepository $rep): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repository = $rep->findWithPhotoAndRecipes($this->getUser()->getId());
        dump($repository);

        if ($this->getUser()->getAvatar() != null) {
            $avatar = base64_encode(stream_get_contents($repository[1]['person_photo']->getPersonPhoto()));
        } else {
            $avatar = null;
        }

        $recipes = [];
        $verifiedRecipes = 0;
        $commentNumber = 0;

        foreach ($repository as $elem) {
            if (isset($elem['recipe']) && !$elem['recipe']->isVerified()) {
                $recipes += [
                    [
                        'id' => $elem['recipe']->getid(),
                        'title' => $elem['recipe']->getRecipeName(),
                    ],
                ];
            } elseif (isset($elem['recipe']) && $elem['recipe']->isVerified()) {
                $verifiedRecipes += 1;
            } elseif (isset($elem['comment'])) {
                $commentNumber += 1;
            }
        }



        //dump(base64_encode(stream_get_contents($userInfos[0]['person']->getAvatar()->getPersonPhoto())));
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
            'user' => $repository[0]['person'],
            'avatar' => $avatar,
            'recipes' => $recipes,
            'verifiedRecipes' => $verifiedRecipes,
            'commentNumber' => $commentNumber
        ]);
    }
}
