<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 24/11/17
 * Time: 08:13
 */

namespace App\Manager;

use App\Entity\User;
use App\Util\PasswordUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class UserManager
 * @package App\Manager
 */
class UserManager
{
    /** @var EntityManagerInterface  */
    private $em;

    /** @var PasswordUpdater  */
    private $passwordUpdater;

    /**
     * UserManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param PasswordUpdater $passwordUpdater
     */
    public function __construct(EntityManagerInterface $em, PasswordUpdater $passwordUpdater)
    {
        $this->em = $em;
        $this->passwordUpdater = $passwordUpdater;
    }

    /**
     * Find a user by his username
     *
     * @param string $username
     *
     * @return \App\Entity\User|null
     */
    public function findUserByUsername($username)
    {
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['username' => $username]);

        return $user;
    }

    /**
     * Update a user
     *
     * @param AdvancedUserInterface $user
     *
     * @param bool $andFlush
     */
    public function updateUser(AdvancedUserInterface $user, $andFlush = true)
    {
        $this->em->persist($user);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * Find a user by his confirmationToken
     *
     * @param $confirmationToken
     *
     * @return \App\Entity\User|null
     */
    public function findUserByConfirmationToken($confirmationToken)
    {
        $user = $this->em->getRepository('App\Entity\User')->findOneBy(['confirmationToken' => $confirmationToken]);

        return $user;
    }

    /**
     * Encode & update user password
     *
     * @param User $user
     */
    public function updateUserPassword(User $user)
    {
        $this->passwordUpdater->hashPassword($user);
        $user->setConfirmationToken(null);
        $user->setPasswordRequestedAt(null);
    }
}
