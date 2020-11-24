<?php

namespace App\Notification;

use App\Entity\Contact;
//use Swift_Mailer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Notification extends AbstractController
{
    private \Swift_Mailer $mailer;
    // private \Swift_Message $message;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        // $this->message = $message;
    }


    public function notifyContact(Contact $contact)
    {
        // creation d'un message avant son envoi
        $message = (new \Swift_Message('Voici mon mail'))
            ->setFrom('hougoune@yahoo.fr')
            ->setTo($contact->getEmail())
            ->setBody(
                $this->render('email/contact.html.twig', [
                    'contact' => $contact
                ]),
                'text/html'

            );
        // envoi du message
        $this->mailer->send($message);
    }
}