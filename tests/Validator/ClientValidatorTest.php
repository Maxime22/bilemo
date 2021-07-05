<?php

namespace App\Tests\Validator;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClientValidatorTest extends KernelTestCase
{
    public function getValidEntity(): Client
    {
        return (new Client())
            ->setUsername("Phone Enterprise Test")
            ->setPassword("1234Jean%1234")
            ;
    }

    public function assertHasErrors(Client $clientEntity, int $errorNumber = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('debug.validator')->validate($clientEntity);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[]= $error->getPropertyPath(). ' => ' . $error->getMessage();
        }
        $this->assertCount($errorNumber, $errors, implode(', ', $messages));
    }

    public function testValidClient()
    {
        $clientEntity = $this->getValidEntity();
        $this->assertHasErrors($clientEntity);
    }

    public function testShortUsernameClient()
    {
        $clientEntity = $this->getValidEntity()->setUsername("Je");
        $this->assertHasErrors($clientEntity, 1);
    }

    public function testInvalidPasswordSizeClient()
    {
        $clientEntity = $this->getValidEntity()->setPassword("Je%1");
        $this->assertHasErrors($clientEntity, 1);
    }

    public function testNotBlankPasswordClient()
    {
        $clientEntity = $this->getValidEntity()->setPassword("");
        $this->assertHasErrors($clientEntity, 1);
    }

    public function testInvalidPasswordNoMajClient()
    {
        $clientEntity = $this->getValidEntity()->setPassword("ee12%defzefez");
        $this->assertHasErrors($clientEntity, 1);
    }

    public function testInvalidPasswordNoMinClient()
    {
        $clientEntity = $this->getValidEntity()->setPassword("EE12%CSDSF");
        $this->assertHasErrors($clientEntity, 1);
    }

    public function testInvalidPasswordNoSpecialCharClient()
    {
        $clientEntity = $this->getValidEntity()->setPassword("EE12dCSDSF");
        $this->assertHasErrors($clientEntity, 1);
    }

    public function testInvalidPasswordNoNumberClient()
    {
        $clientEntity = $this->getValidEntity()->setPassword("EE%dCSDSF");
        $this->assertHasErrors($clientEntity, 1);
    }

    public function testInvalidUsedUsernameClient(){
        // Phone Enterprise is the first username created by the fixture
        $clientEntity = $this->getValidEntity()->setUsername("Phone Enterprise");
        $this->assertHasErrors($clientEntity, 1);
    }

}