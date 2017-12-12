<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 24/11/17
 * Time: 19:03
 */

namespace App\Entity\Behavior;

use App\Entity\User;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Interface UserableInterface
 * @package App\Behavior
 */
interface UserableInterface
{
    /**
     * @return User
     */
    public function getUser();

    /**
     * @param AdvancedUserInterface $user
     *
     * @return UserableInterface
     */
    public function setUser(AdvancedUserInterface $user);
}
