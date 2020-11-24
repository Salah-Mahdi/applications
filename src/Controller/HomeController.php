<?php
//creation d'un namespace => App selon le fichier json
namespace App\Controller;

use DateTime;
use App\Entity\Contact;

use App\Entity\Recette;

use App\Form\ContactType;
use App\Notification\Notification;
//use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecetteRepository;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * classe abstractController : classe rendant des services 
 * dans un conteneur les : twig, router, session, ... 
 */
class HomeController extends AbstractController
{


    // l'autowiring
    /**
     * @Route("/", name="home_index")
     */

    public function index(RecetteRepository $recetteRepository)
    {
        //methode de récupération
        $recettes = $recetteRepository->findBy([], ['id' => 'DESC']);


        // render : methode renvoyant une vue : ici base.html.twig
        return $this->render('home/index.html.twig', [
            'recettes' => $recettes,
            'menu' => 'home'
        ]);
    }


    /* creation d'une fonction  contact() pour le routage, la recuperation
    et l'envoi du mail
     */

    /**
     * @Route("/contact", name="home_contact")
     */
    public function contact(Request $request, Notification $notification)
    {
        // creatioon de l'objet contact
        $contact = new Contact();
        // creation du formulaire avec la methode createForm
        $form = $this->createForm(ContactType::class, $contact);
        // recuperation de l'envoi du user
        $form->handleRequest($request);

        // test si le formulaire est envoyé et valide
        // installer le bundle (la librairie de  swiftMailer) 
        // composer require symfony/swiftmailer-bundle
        /* configurer le fichier env et le fichier switfmailer

        */
        if ($form->isSubmitted() && $form->isValid()) {
            //$notification = new Notification();

            $notification->notifyContact($contact);
            // message de succès de l'envoi
            $this->addFlash('success', 'Le message a été envoyé avec succès');

            // renvoi vers la route( page : home_contact)
            //return $this->redirectToRoute('home_contact');
            return $this->redirectToRoute('home_index', [], 301);
        }

        //renvoi vers la vue contact.html.twig
        return $this->render('home/contact.html.twig', [
            'formContact' => $form->createView()

        ]);
    }
}