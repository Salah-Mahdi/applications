<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{

    // fonction de génération  du formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [

                "required" => false,
                "attr" => [
                    "placeholder" => "Votre nom"
                ]
            ])
            ->add('prenom', TextType::class, [

                "required" => false,
                "attr" => [
                    "placeholder" => "Votre prenom"
                ]
            ])
            ->add('email', EmailType::class, [

                "required" => false,
                "attr" => [
                    "placeholder" => "Votre email"
                ]
            ])
            ->add('message', TextareaType::class, [

                "required" => false,
                "attr" => [
                    "placeholder" => "Votre message"
                ]
            ]);
    }

    // fonction definissant l'appartenance à quelle classe
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}