<?php

namespace Instante\Doctrine\Users;

use Doctrine\Common\Persistence\ObjectRepository;
use Nette\Http\Session;
use Nette\InvalidArgumentException;
use Nette\Security\Identity;
use Nette\Security\IIdentity;

/**
 *
 * @author Richard Ejem <richard(at)ejem.cz>
 */
class UserStorage extends \Nette\Http\UserStorage
{
    /** @var IIdentity */
    private $identity = NULL;

    function __construct(ObjectRepository $userRepository, Session $sessionHandler)
    {
        parent::__construct($sessionHandler);
        $identity = parent::getIdentity();
        if ($identity !== NULL) {
            $identity = $userRepository->find($identity->getId());
        }
        $this->identity = $identity;
    }

    /**
     * @param \Nette\Security\IIdentity
     * @return UserStorage
     */
    public function setIdentity(IIdentity $identity = NULL)
    {
        if (!($identity instanceof User || $identity === NULL)) {
            throw new InvalidArgumentException(__CLASS__ . '::' . __METHOD__ . ' needs instance of ' . User::class . ', got ' . get_class($identity));
        }
        $this->identity = $identity;
        return parent::setIdentity($identity === NULL ? NULL : new Identity($identity->getId()));
    }

    /** @return IIdentity|NULL */
    public function getIdentity()
    {
        return $this->identity;
    }
}
