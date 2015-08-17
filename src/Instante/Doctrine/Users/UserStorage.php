<?php

namespace Instante\Doctrine\Users;

/**
 *
 * @author Richard Ejem <richard(at)ejem.cz>
 */
class UserStorage extends \Nette\Http\UserStorage
{
    /**@var \Kdyby\Doctrine\EntityDao */
    private $userDao;

    function __construct(\Kdyby\Doctrine\EntityDao $userDao, \Nette\Http\Session $sessionHandler)
    {
        parent::__construct($sessionHandler);
        $this->userDao = $userDao;
    }

    /**
     * @param \Nette\Security\IIdentity
     * @return UserStorage
     */
    public function setIdentity(\Nette\Security\IIdentity $identity = NULL)
    {
        $this->identity = $identity;
        if ($identity instanceof User) {
            $identity = new \Nette\Security\Identity($identity->getId());
        }
        return parent::setIdentity($identity);
    }

    /**
     * @return \Nette\Security\IIdentity|NULL
     */
    public function getIdentity()
    {
        $identity = parent::getIdentity();
        if (!$identity) {
            return NULL;
        }

        return $this->userDao->find($identity->getId());
    }
}
