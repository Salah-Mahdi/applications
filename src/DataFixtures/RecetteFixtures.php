<?php

namespace App\DataFixtures;

//use App\DataFixtures\Faker\factory;
use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class RecetteFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // faker : objet de creation des fausses données
        $faker = Faker\Factory::create();

        $entree = (new Categorie())->setNom('Entrée');
        $plat = (new Categorie())->setNom('Plat');
        $dessert = (new Categorie())->setNom('Dessert');
        $categories = [$entree, $plat, $dessert];

        $user = new User();
        $user
            ->setUsername('salah')
            ->setPassword($this->encoder->encodePassword($user, "test"))
            ->setRoles(['ROLE_USER']);

        /*
        $user = new User();
        
       $user->setUsername('salah')
       
       ->setPassword('bonjour')
       ->setRoles(['ROLE_USER']);
      */
        // il faut persister ces objets
        $manager->persist($user);


        $manager->persist($entree);
        $manager->persist($plat);
        $manager->persist($dessert);
        //  realisation d'un flush
        $manager->flush();

        for ($i = 0; $i <= 50; $i++) {

            $recette = new Recette();
            $recette
                ->setTitre($faker->name())
                ->setResumer($faker->sentence(20))
                ->setPreparation($faker->text(500))
                ->setPersonne($faker->randomDigit())
                ->setTemps($faker->randomDigit() . "min")
                ->setCategorie($faker->randomElement($categories))
                ->setUser($user);

            $manager->persist($recette);
        }


        $manager->flush();
    }
}