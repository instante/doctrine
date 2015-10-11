<?php

namespace Instante\Doctrine\Users;
use Doctrine\Common\Persistence\ObjectRepository;
use Nette\Http\Session;
use Nette\Security\Identity;
use Nette\Security\IIdentity;

/**
 *
 * @author Richard Ejem <richard(at)ejem.cz>
 */
class UserStorage extends \Nette\Http\UserStorage
{
    /** @var ObjectRepository */
    private $userRepository;

    /** @var IIdentity */
    private $identity = NULL;

    function __construct(ObjectRepository $userRepository, Session $sessionHandler)
    {
        parent::__construct($sessionHandler);
        $this->userRepository = $userRepository;
    }

    /**
     * @param \Nette\Security\IIdentity
     * @return UserStorage
     */
    public function setIdentity(IIdentity $identity = NULL)
    {
        if ($identity instanceof User) {
            $identity = new Identity($identity->getId());
        }
        $this->identity = $identity;
        return parent::setIdentity($identity);
    }

    /**
     * @return IIdentity|NULL
     */
    public function getIdentity()
    {
        $identity = parent::getIdentity();
        if (!$identity) {
            return NULL;
        }

        if ($this->identity !== NULL && $identity->getId() === $this->identity->getId()) {
            return $this->identity;
        } else {
            return $this->userRepository->find($identity->getId());
        }
    }
}
