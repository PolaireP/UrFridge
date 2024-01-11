<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\PersonPhoto;
use App\Form\PersonPhotoType;
use App\Form\PersonType;
use App\Repository\PersonPhotoRepository;
use App\Repository\PersonRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use function Zenstruck\Foundry\repository;

class PersonController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(PersonRepository $rep): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repository = $rep->findWithPhotoAndRecipes($this->getUser()->getId());

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

    #[Route('/profil/{id}/update', requirements: ['id' => '\d+'])]
    public function update(Person $person, PersonPhoto $personPhoto = null, PersonPhotoRepository $rep, Request $request, EntityManagerInterface $manager): Response {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        if ($this->getUser()->getId() != $person->getId()) {
            return $this->redirectToRoute('app_person_update', ['id' => $this->getUser()->getId()]);
        }

        if ($personPhoto != null) {
            $personPhoto = $rep->findOneBy(['id' => $personPhoto->getId()]);
            $avatar = base64_encode(stream_get_contents($personPhoto->getPersonPhoto()));
        } else {
            $avatar = null;
        }


        $form = $this->createForm(PersonType::class, $person, ['attr' => [ 'class' => 'edit-profile-informations-form' ]]);
        //$imageForm = $this->createForm(PersonPhotoType::class,$personPhoto, ['attr' => ['class' => 'profile-picture-input']]);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $manager->flush();

            return $this->redirectToRoute('app_profil');
        }


        return $this->render('person/update.html.twig', [
            'user' => $person,
            'updateForm' => $form,
            'avatar' => $avatar,
        ]);
    }
}
