<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    private string $nom;
    private string  $prenom;
    private string  $email;
    /**
     * @Assert\Length(min = 10)
     */
    private string $message;



    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * set the value of nom
     * 
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * set the value of prenom
     * 
     * @return  self
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set the value of email
     * 
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of massage
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * set the value of message
     * 
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}