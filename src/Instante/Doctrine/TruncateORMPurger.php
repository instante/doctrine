<?php

namespace Instante\Doctrine;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class TruncateORMPurger extends ORMPurger
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $em = null, array $excluded = array())
    {
        $this->entityManager = $em;
        parent::__construct($em, $excluded);
    }

    /**
     * Purge the data from the database for the given EntityManager.
     *
     * @return void
     */
    public function purge()
    {
        $connection = $this->entityManager->getConnection();
        $connection->prepare('SET FOREIGN_KEY_CHECKS = 0')->execute();
        parent::purge();
        $connection->prepare('SET FOREIGN_KEY_CHECKS = 1')->execute();
        $this->entityManager->clear();
    }
}
