<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{

    public const DEMO_CLIENT_1_REFERENCE = 'demo-client-1';
    public const DEMO_CLIENT_2_REFERENCE = 'demo-client-2';

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setUsername("Phone Enterprise");
        $client->setPassword($this->passwordHasher->hashPassword($client, "1234Jean%1234"));
        $manager->persist($client);

        $client2 = new Client();
        $client2->setUsername("Mobile Start");
        $client2->setPassword($this->passwordHasher->hashPassword($client2, "1234Jean%1234"));
        $manager->persist($client2);

        $manager->flush();

        $this->addReference(self::DEMO_CLIENT_1_REFERENCE, $client);
        $this->addReference(self::DEMO_CLIENT_2_REFERENCE, $client2);
    }
}
