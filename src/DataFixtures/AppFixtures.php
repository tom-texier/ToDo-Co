<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin
            ->setPassword($this->userPasswordHasher->hashPassword($admin, '1adminadmin'))
            ->setEmail('admin@todoandco.com')
            ->setUsername('admin')
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user
                ->setPassword($this->userPasswordHasher->hashPassword($user, '1adminadmin'))
                ->setEmail('user' . ($i + 1)  . '@todoandco.com')
                ->setUsername('utilisateur' . ($i + 1));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
