<?php

namespace tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest  extends TestCase
{
    public function testGetId()
    {
        $user = $this->getUser();
        $this->assertEquals(NULL, $user->getId());
    }

    public function testUsername()
    {
        $user = $this->getUser();
        $this->assertEquals(NULL, $user->getUsername());
    }

    public function testSalt()
    {
        $user = $this->getUser();
        $this->assertEquals(NULL, $user->getSalt());
        $this->assertEquals(NULL, $user->setSalt());
    }

    public function testEmail()
    {
        $user = $this->getUser();
        $this->assertEquals(NULL, $user->getEmail());

        $email = "toto@test.com";

        $user->setEmail($email);

        $this->assertEquals($email, $user->getEmail());
    }

    public function testPassword()
    {
        $user = $this->getUser();
        $this->assertEquals(NULL, $user->getPassword());

        $password = "password";

        $user->setPassword($password);

        $this->assertEquals($password, $user->getPassword());
    }

    public function testIsActive()
    {
        $user = $this->getUser();
        $this->assertEquals(true, $user->isActive());

        $active = false;

        $user->setActive($active);

        $this->assertEquals($active, $user->isActive());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|User
     */
    protected function getUser()
    {
        return $this->getMockForAbstractClass(User::class);
    }
}