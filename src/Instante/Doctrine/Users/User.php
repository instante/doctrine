<?php
namespace Instante\Doctrine\Users;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
abstract class User extends \Nette\Object implements \Nette\Security\IIdentity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=50,unique=true)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string",length=60,nullable=true)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="boolean")
     * @var string
     */
    protected $active = 1;

    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $this->hashPassword($password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
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
     * Password is salted by name - you cannot change only user name without re-entering password
     *
     * @param string $name
     * @param string $password
     * @return self fluent
     */
    public function setNameAndPassword($name, $password)
    {
        $this->name = $name;
        $this->setPassword($password);
        return $this;
    }

    public function setPassword($password)
    {
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

    protected function hashPassword($password)
    {
        return password_hash($this->saltPassword($password), PASSWORD_BCRYPT);
    }

    private function saltPassword($password)
    {
        return $password . $this->name;
    }

    public function getRoles()
    {
        return array();
    }
}
