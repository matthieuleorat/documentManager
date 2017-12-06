<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 05/12/17
 * Time: 13:24
 */

namespace App\Security;


use App\Entity\Tag;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TagVoter extends Voter
{
    const VIEW      = 'view';
    const EDIT      = 'edit';
    const DELETE    = 'delete';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Tag) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $document, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($document->getUser()->getId() === $user->getId()) {
            return true;
        }

        return false;
    }
}
