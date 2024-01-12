<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\PersonPhoto;
use App\Entity\Recipe;
use App\Entity\RecipePhoto;
use App\Form\PersonPhotoType;
use App\Form\PersonType;
use App\Repository\CommentaryRepository;
use App\Repository\CommentRepository;
use App\Repository\PersonPhotoRepository;
use App\Repository\PersonRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        return $this->render('pages/person/index.html.twig', [
            'controller_name' => 'PersonController',
            'user' => $repository[0]['person'],
            'avatar' => $avatar,
            'recipes' => $recipes,
            'verifiedRecipes' => $verifiedRecipes,
            'commentNumber' => $commentNumber
        ]);
    }

    #[Route('/profil/{id}/update', requirements: ['id' => '\d+'])]
    public function update(Person $person = null, PersonPhoto $personPhoto = null, PersonPhotoRepository $rep, Request $request, EntityManagerInterface $manager): Response {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        if ($person === null || $this->getUser()->getId() != $person->getId()) {
            return $this->redirectToRoute('app_person_update', ['id' => $this->getUser()->getId()]);
        }

        if ($personPhoto != null) {
            $personPhoto = $rep->findOneBy(['id' => $personPhoto->getId()]);
            $avatar = base64_encode(stream_get_contents($personPhoto->getPersonPhoto()));
        } else {
            $avatar = null;
        }


        $form = $this->createForm(PersonType::class, $person, ['attr' => [ 'class' => 'edit-profile-informations-form' ]])
            ->add('firstname', options: [
                'required' => true,
                'label' => false,
                'row_attr' => ['id' => 'firstname'],
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'profile-information-input',
                    'autocomplete' => 'given-name',
                    'id' => 'firstname',
                ],
            ])
            ->add('lastname', options: [
                'required' => true,
                'label' => false,
                'row_attr' => ['id' => 'lastname'],
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'profile-information-input',
                    'autocomplete' => 'family-name',
                    'id' => 'lastname',
                ],
            ])
            ->add('email', options: [
                'required' => true,
                'label' => false,
                'row_attr' => ['id' => 'email'],
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'profile-information-input',
                    'autocomplete' => 'email',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe",
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Votre mot de passe doit faire {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options' => [
                    'attr' => ['placeholder' => 'Mot de passe', 'class' => 'profile-information-input'],
                    'label' => false,
                    'row_attr' => ['id' => 'password'],
                ],
                'second_options' => [
                    'attr' => ['placeholder' => 'Confirmer le mot de passe', 'class' => 'profile-information-input'],
                    'label' => false,
                    'row_attr' => ['id' => 'confirm-password'],
                ],
            ]);

        //$imageForm = $this->createForm(PersonPhotoType::class,$personPhoto, ['attr' => ['class' => 'profile-picture-input']]);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $manager->flush();

            return $this->redirectToRoute('app_profil');
        }


        return $this->render('pages/person/update.html.twig', [
            'user' => $person,
            'updateForm' => $form,
            'avatar' => $avatar,
        ]);
    }

    #[Route('/profil/{id}/delete', requirements: ['id' => '\d+'])]
    public function delete(Person $person = null, SessionInterface $session, RecipeRepository $rep, CommentRepository $cmtRep, CommentaryRepository $cmtrRep, EntityManagerInterface $manager, Request $req): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        if ($person === null || $this->getUser()->getId() != $person->getId()) {
            return $this->redirectToRoute('app_person_delete', ['id' => $this->getUser()->getId()]);
        }

        $deleteForm = $this->createForm(PersonType::class, $person)
            ->add('supprimer', SubmitType::class)
            ->add('annuler', SubmitType::class);

        $deleteForm->handleRequest($req);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            if ($deleteForm->getClickedButton() === $deleteForm->get('supprimer')) {

                $recipesToDelete = $rep->findBy(['author' => $person->getId()]);
                foreach ($recipesToDelete as $elem) {
                    $elem->setAuthor(null);
                }

                $commentsToDelete = $cmtRep->findBy(['writer' => $person->getId()]);
                foreach ($commentsToDelete as $elem) {
                    $commentary = $cmtrRep->findOneBy(['id' => $elem->getCommentary()]);
                    $elem->setCommentary(null);
                    $elem->setWriter(null);
                    $elem->setRecipe(null);
                    $manager->remove($commentary);
                    $manager->remove($elem);
                }

                $manager->remove($person);
                $req->getSession()->invalidate();
                $this->container->get('security.token_storage')->setToken(null);
                $manager->flush();

                return $this->redirectToRoute('app_home');
            } else {
                return $this->redirectToRoute('app_profil');
            }
        }

        return $this->render('pages/person/delete.html.twig', [
            'deleteForm' => $deleteForm,
        ]);
    }

    #[Route('/profil/favorites')]
    public function favorites() {
        return $this->render('pages/person/favorites.html.twig');
    }

    #[Route('/profil/getfavorites')]
    public function getfavorites(RecipeRepository $repository, Request $request) : JsonResponse {
        $jsonData = json_decode($request->getContent(), true);
        $searchString = $jsonData['search'] ?? '';
        $recipes = $repository->findPersonFavoriteRecipes($this->getUser()->getId(), $searchString);

        $recipeCollection = [];

        foreach ($recipes as $recipe) {
            $recipeCollection[] = [
                'id' => $recipe[0]->getId(),
                'recipeName' => $recipe[0]->getRecipeName(),
                'recipePhoto' => base64_encode(stream_get_contents($recipe['recipePhoto'])),
                'author' => $recipe[0]->getAuthor()->getFirstname().' '.$recipe[0]->getAuthor()->getLastname(),
                'steps' => $recipe[0]->getSteps()->count(),
                'recipeLink' => $this->generateUrl('app_recipe_show', ['id' => $recipe[0]->getId()])
            ];
        }

        return new JsonResponse($recipeCollection, Response::HTTP_OK);
    }

}
