<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecetteRepository;
use App\Form\RecetteType;
use App\Entity\Recette;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
 
use DateTime;
class AdminRecetteController extends AbstractController
{
    private EntityManagerInterface $em;
    private RecetteRepository $repository;

    // creation  d'un constructeur  de l'entitymanagerInterface
    // et initialisation de l'attribut em
    
    public function __construct(EntityManagerInterface $em, RecetteRepository $repository){
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin_index")
     */
    public function index():response
    {
        //methode de récupération de toute la table
        $recettes = $this->repository->findAll();
        
       
        // render : methode renvoyant une vue : ici base.html.twig
        // cle valeur
        return $this->render('admin/index.html.twig', [
            'recettes' => $recettes,
            'menu' => 'admin'
        ]);
       

    }
    /**
     * @Route("/admin/create", name="admin_create")
     */
    //parametre request est la requette
    public function create(Request $request){
        $recette = new Recette();
        $recette->setCreatedAt(new DateTime());
        // appel a la methode createform se trouvant dans l'abstractController
        // parametres : la classe RecetteType, $recette : objet de stockage
        $form = $this->createform(RecetteType::class, $recette );
        // methode HandlerRequest : permet la récupération et la lisaion entre le formulaire
        // et la requete envoyée
        $form->handleRequest($request);

        // enregistrement dans la bdd
        //si le formullaire est envoyé et si il est valide 
        if($form->isSubmitted() && $form->isValid()){

            $this->em->persist($recette);
            $this->em->flush();

            //message de succès de l'enregfistrement : parametres cle-valeur
            $this->addFlash('success', "La recette a été enregistrée");
            // redirection vers la vue admin_index, parametre 301 = redirection 
            return $this->redirectToRoute('admin_index', [] ,301);

        }
        // envoi du formulaire dans la vue en creant la vue avec createForms
        return $this->render('admin/create.html.twig', [
            'formRecette' => $form->createView(),
            'menu' => 'admin'
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
        if($form->isSubmitted() && $form->isValid()){

            $this->em->flush();
            //message de succès de l'enregfistrement : parametres cle-valeur
            $this->addFlash('success', "La recette a été mis à jour");
            // redirection vers la vue admin_index, parametre 301 = redirection 
            // [] = tableau sans parametres
            return $this->redirectToRoute('admin_index', [] ,301);

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

/*
    public function usersList(UserRepository $users){

        return $this->render("admin/users.html.twig", [
            'users' => $users->findAll()
        ]);
    }
*/
    
}



?>