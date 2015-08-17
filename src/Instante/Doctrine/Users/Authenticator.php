<?php

namespace Instante\Doctrine\Users;

use Doctrine\Common\Persistence\ObjectRepository;
use Nette\Object;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;

/**
 * Users authenticator.
 *
 * @author     Richard Ejem
 */
class Authenticator extends Object implements IAuthenticator
{

    /** @var ObjectRepository */
    private $userRepository;

    function __construct(ObjectRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Performs an authentication
     * @param  array
     * @return User
     * @throws \Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        $user = $this->userRepository->findOneBy(['name' => $username]);

        if ($user === NULL) {
            throw new AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
        }
        if (!$user->isActive()) {
            throw new AuthenticationException("User '$username' is inactive.", self::NOT_APPROVED);
        }
        if (!$user->checkPassword($password)) {
            throw new AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
        }

        return $user;
    }

}
