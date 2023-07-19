<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    private UserRepository $userRepository;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @codeCoverageIgnore
     */
    public function load(ObjectManager $manager): void
    {
        $users = $this->userRepository->findAll();
        $users[] = null;

        $tasksTitle = ['Réunion 17/03', 'Métro', 'Numéro de téléphone', 'Liste de courses', '5 mai 2023', 'Livres à lire', 'Musique', 'Site web', 'Rappels', 'Médecin', '29/04'];
        $tasksContent = [
            'Anniversaire de Grégory',
            '- Beurre <br> - Endives <br> - Poireau <br> - Bananes <br> - Carottes <br> - Champignons <br>',
            'Préparer la soutenance <br>',
            'Saint-Germain-les-Prés <br> Ligne 3',
            'Sortir les poubelles <br> Promener le chien',
            'L\'Étranger, Sapiens, Le Pouvoir du Moment Présent, Les quatre accords toltèques',
            'www.senscritique.com <br> www.allocine.com <br> www.last.fm'
        ];

        $status = [true, false];

        for ($i = 0; $i < 30; $i++) {
            $task = new Task();
            $task->setTitle($tasksTitle[array_rand($tasksTitle)]);
            $task->setContent($tasksContent[array_rand($tasksContent)]);
            $task->toggle($status[array_rand($status)]);
            $task->setAuthor($users[array_rand($users)]);
            $manager->persist($task);
        }

        $manager->flush();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
