<?php

namespace Instante\Doctrine\Helpers;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Nette\NotSupportedException;

class FixtureSupport
{
    public static function check()
    {
        if (!interface_exists(FixtureInterface::class)) {
            throw new NotSupportedException('Please install doctrine/data-fixtures interface.');
        }
    }
}
