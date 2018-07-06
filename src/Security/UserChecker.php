<?php

namespace App\Security;

use App\Entity\User;
use App\Exception\AccountNonActiveException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * Advanced check user before login
     * 
     * @param UserInterface $user
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        $status = $user->getStatus();
        if (is_null($status)) {
            throw new AccountNonActiveException();
        }
        if ($status ==2) {
            throw new LockedException();
        }
    }

    /**
     * Advanced check user after login
     *
     * @param UserInterface $user
     */
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
    }
}