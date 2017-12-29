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
        $this->assertEquals(true, $user->isEnabled());

        $active = false;

        $user->setActive($active);

        $this->assertEquals($active, $user->isActive());
        $this->assertEquals($active, $user->isEnabled());
    }

    public function testGetRoles()
    {
        $user = $this->getUser();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testIsAccountNonExpired()
    {
        $user = $this->getUser();
        $this->assertTrue($user->isAccountNonExpired());
    }

    public function testIsAccountNonLocked()
    {
        $user = $this->getUser();
        $this->assertTrue($user->isAccountNonLocked());
    }

    public function testIsCredentialsNonExpired()
    {
        $user = $this->getUser();
        $this->assertTrue($user->isCredentialsNonExpired());
    }

    public function testConfirmationToken()
    {
        $user = $this->getUser();
        $this->assertNull($user->getConfirmationToken());

        $confirmationToken = "sdfqs6f54";

        $user->setConfirmationToken($confirmationToken);
        $this->assertEquals($confirmationToken, $user->getConfirmationToken());
    }

    public function testPasswordRequetedAt()
    {
        $user = $this->getUser();
        $this->assertNull($user->getPasswordRequestedAt());

        $passwordRequestedAt = new \DateTime();
        $user->setPasswordRequestedAt($passwordRequestedAt);
        $this->assertEquals($passwordRequestedAt, $user->getPasswordRequestedAt());

        $ttl = 1114400; // 310 heures
        $this->assertTrue($user->isPasswordRequestNonExpired($ttl));
    }

    public function testSerialization()
    {
        $user = $this->getUser();

        $serialized = $user->serialize();
        $this->assertTrue(is_string($serialized));
        $this->assertTrue(is_array($user->unserialize($serialized)));

    }

    public function testEraseCredentials()
    {
        $user = $this->getUser();
        $user->eraseCredentials();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|User
     */
    protected function getUser()
    {
        return $this->getMockForAbstractClass(User::class);
    }
}