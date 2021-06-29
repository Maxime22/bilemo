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

    /* public function testShortTitleTrick()
    {
        $trick = $this->getValidEntity()->setTitle("He");
        $this->assertHasErrors($trick, 1);
    } */

    /* public function testShortContentTrick()
    {
        $trick = $this->getValidEntity()->setContent("Blabla");
        $this->assertHasErrors($trick, 1);
    }

    public function testInvalidBlankTitleTrick()
    {
        $trick = $this->getValidEntity()->setTitle("");
        $this->assertHasErrors($trick, 1);
    }

    public function testInvalidBlankContentTrick()
    {
        $trick = $this->getValidEntity()->setContent("");
        $this->assertHasErrors($trick, 1);
    }

    // test the unicity of the slug
    public function testInvalidUsedSlugTrick(){
        $trick = $this->getValidEntity()->setSlug("le-180");
        $this->assertHasErrors($trick, 1);
    } */
}
