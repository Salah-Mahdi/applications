<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\User;
use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatRecetteController extends AbstractController
{
    private EntityManagerInterface $em;
    private RecetteRepository $repository;

    public function __construct(EntityManagerInterface $em, RecetteRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }



    /**
     * @Route("/home", name="user_index")
     */
    public function index(): response
    {
        $recettes = $this->repository->findAll();

        return $this->render('user/proposer.html.twig', [
            'recettes' => $recettes,
            'menu' => 'home'


        ]);
    }
    /*  'menu' => 'admin' */

    /**
     * @Route("/user/create", name="user_create")
     */
    //parametre request est la requette
    public function create(Request $request)
    {
        $user = new User();
        $recette = new Recette();
        /* $recette->setCreatedAt(new DateTime());  */

        // appel a la methode createform se trouvant dans l'abstractController
        // parametres : la classe RecetteType, $recette : objet de stockage
        $form = $this->createform(RecetteType::class, $recette);
        // methode HandlerRequest : permet la récupération et la lisaion entre le formulaire
        // et la requete envoyée
        $form->handleRequest($request);

        // enregistrement dans la bdd
        //si le formullaire est envoyé et si il est valide 
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();

            /* creation d'une recette avec un user */
            $recette->setCreatedAt(new DateTime());
            $recette->setUser($this->getUser());
            /* fin creation */

            $this->em->persist($recette);
            $this->em->flush();

            //message de succès de l'enregfistrement : parametres cle-valeur
            $this->addFlash('success', "La recette a été enregistrée");
            // redirection vers la vue admin_index, parametre 301 = redirection 
            return $this->redirectToRoute('home_index', ['id' => $recette->getId()], 301);
        }
        // envoi du formulaire dans la vue en creant la vue avec createForms
        return $this->render('user/proposer.html.twig', [
            'formRecette' => $form->createView(),
            'menu' => 'home'
        ]);
    }


    /**
     * @Route("/admin/edit/{id}", name="admin_edit")
     */
    public function edit(Request $request, int $id)

    {   // Repository : objet permettant de faire des requetes sql
        // la recette correspondant à l'id qui recuperée
        $recette = $this->repository->find($id);

        $form = $this->createform(RecetteType::class, $recette);
        // lien entre le formulaire et la saisie user
        $form->handleRequest($request);
        // enregistrement dans la bdd
        //si le formullaire est envoyé et s'il est valide 
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->flush();
            //message de succès de l'enregfistrement : parametres cle-valeur
            $this->addFlash('success', "La recette a été mis à jour");
            // redirection vers la vue admin_index, parametre 301 = redirection 
            // [] = tableau sans parametres
            return $this->redirectToRoute('admin_index', [], 301);
        }
        // envoi du formulaire dans la vue en creant la vue avec createForms
        return $this->render('admin/edit.html.twig', [
            'menu' => 'admin',
            'formRecette' => $form->createView()
            /**
             * envoi du menu et du formulaire formRecette
             */
        ]);
    }
}