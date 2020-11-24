<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture

{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;

    }

    public function load(ObjectManager $manager)
    {
        /* creationn d'un user admin avec ses 3 propriétés */
        $admin = new User();
        $admin
                ->setUsername('admin')
                ->setPassword($this->encoder->encodePassword($admin, "admin"))
                ->setRoles(['ROLE_ADMIN']);

                $user = new User();
                $user
                ->setUsername('user')
                ->setPassword($this->encoder->encodePassword($user, "user"))
                ->setRoles(['ROLE_USER']);


        // $product = new Product();
        // $manager->persist($product);

        $manager->persist($admin);
        $manager->persist($user);

        $manager->flush();
    }
}
