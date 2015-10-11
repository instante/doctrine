<?php
namespace Instante\Doctrine\Users;

use Doctrine\ORM\Mapping as ORM;
use Nette\Security\IIdentity;

/** @ORM\MappedSuperclass */
abstract class User implements IIdentity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=50)
     * @var string
     */
    private $salt;

    /**
     * @ORM\Column(type="string",length=60,nullable=true)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     * @var string
     */
    private $active = 1;

    public function __construct($salt, $password)
    {
        $this->salt = $salt;
        $this->password = $this->hashPassword($password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param string $password
     * @param string $salt - can be optionally changed
     * @return self fluent
     */
    public function setPassword($password, $salt = NULL)
    {
        if ($salt !== NULL) {
            $this->salt = $salt;
        }
        $this->password = $this->hashPassword($password);
        return $this;
    }

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function checkPassword($password)
    {
        return password_verify($this->saltPassword($password), $this->password);
    }

    private function hashPassword($password)
    {
        return password_hash($this->saltPassword($password), PASSWORD_BCRYPT);
    }

    private function saltPassword($password)
    {
        return $password . $this->salt;
    }

    public function getRoles()
    {
        return array();
    }
}
