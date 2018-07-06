<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

/**
 * AccountNonActiveException is thrown when the user account is  non activated.
 *
 */
class AccountNonActiveException extends AccountStatusException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Account non activated.';
    }
}