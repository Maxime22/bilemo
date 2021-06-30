<?php

namespace App\Tests\Validator;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserValidatorTest extends KernelTestCase
{
    public function getValidEntity(): User
    {
        return (new User())
            ->setMail("demo666@hotmail.fr")
            ->setFirstName("John")
            ->setLastName("Doe")
            ;
    }

    public function assertHasErrors(User $user, int $errorNumber = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('debug.validator')->validate($user);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[]= $error->getPropertyPath(). ' => ' . $error->getMessage();
        }
        $this->assertCount($errorNumber, $errors, implode(', ', $messages));
    }

    public function testValidUser()
    {
        $user = $this->getValidEntity();
        $this->assertHasErrors($user);
    }

    public function testWrongMailUser()
    {
        $user = $this->getValidEntity()->setMail("demo666hotmail.fr");
        $this->assertHasErrors($user, 1);
    }

    public function testBlankMailUser()
    {
        $user = $this->getValidEntity()->setMail("");
        $this->assertHasErrors($user, 1);
    }

    public function testShortFirstNameUser()
    {
        $user = $this->getValidEntity()->setFirstName("A");
        $this->assertHasErrors($user, 1);
    }

    public function testBlankFirstNameUser()
    {
        $user = $this->getValidEntity()->setFirstName("");
        $this->assertHasErrors($user, 1);
    }

    public function testShortLastNameUser()
    {
        $user = $this->getValidEntity()->setLastName("A");
        $this->assertHasErrors($user, 1);
    }

    public function testBlankLastNameUser()
    {
        $user = $this->getValidEntity()->setLastName("");
        $this->assertHasErrors($user, 1);
    }
}
