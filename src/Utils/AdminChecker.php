<?php
namespace App\Utils;

use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class AdminChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user)
    {}

    public function checkPostAuth(UserInterface $user)
    {
        if (!in_array('ROLE_ADMIN', $user->getRoles())) {
            throw new CustomUserMessageAccountStatusException("Vous n'êtes pas un administrateur");
        }
    }
}

