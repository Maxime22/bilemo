<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $client1 = $this->getReference(ClientFixtures::DEMO_CLIENT_1_REFERENCE);
        $client2 = $this->getReference(ClientFixtures::DEMO_CLIENT_2_REFERENCE);

        $data = [
            "mail"=>["demouser1@hotmail.fr","demouser2@hotmail.fr","demouser3@hotmail.fr", "demouser4@hotmail.fr","demouser5@hotmail.fr"],
            "firstName"=>["Jean","Maxime","Lucie","Cristin","Thomas"],
            "lastName"=>["Martin","Dupond","Durand","Milioti","Hobbes"]
        ];
        for ($i = 0; $i < count($data['mail']); $i++) {
            $user = new User();
            $user->setMail($data["mail"][$i]);
            $user->setFirstName($data["firstName"][$i]);
            $user->setLastName($data["lastName"][$i]);
            if($i%2===0){
                $user->setClient($client1);
            }else{
                $user->setClient($client2);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class,
        ];
    }
       
}
