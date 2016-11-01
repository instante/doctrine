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

    /** @var string */
    private $nameColumn;

    function __construct(ObjectRepository $userRepository, $nameColumn = 'name')
    {
        $this->userRepository = $userRepository;
        $this->nameColumn = $nameColumn;
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

        $user = $this->userRepository->findOneBy([$this->nameColumn => $username]);

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
