<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre', TextType::class, [
                "label" => "Nom de la recette",
                "required" => false,
                "attr" => [
                    "placeholder" => "Nom de la recette"
                ]
            ])
            ->add('resumer', TextType::class, [
                "label" => "Resumé de la recette",
                "required" => false,
            ])
            ->add('preparation', TextareaType::class, [
                "attr" => [
                    "rows" => 8
                ],
                "required" => false,
            ])
            ->add('temps', TextType::class, [
                "required" => false,
            ])
            ->add('personne', NumberType::class, [
                "required" => false,
            ])
            ->add('categorie', EntityType::class, [
                "label" => "Choix de la categorie",
                "class" => Categorie::class,
                "choice_label" => 'nom'


            ])
            ->add('imageFile', FileType::class, [
                "label" => "Image de la recette",
                "required" => false
            ])

            //->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}