<?php

namespace Instante\Doctrine;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;

class FixtureLoader
{
    /** @var EntityManager */
    private $em;

    private $fixtures = [];

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function addFixture(FixtureInterface $fixture)
    {
        $this->fixtures[] = $fixture;
    }

    public function executeFixtures($append = false, callable $logger = null) {
        $purger = new ORMPurger($this->em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $executor = new ORMExecutor($this->em, $purger);
        if ($logger !== null) {
            $executor->setLogger($logger);
        }
        $executor->execute($this->getFixtures(), $append);
    }

    public function getFixtures()
    {
        $loader = new Loader();
        foreach ($this->fixtures as $fixture) {
            $loader->addFixture($fixture);
        }
        return $loader->getFixtures();
    }
}
