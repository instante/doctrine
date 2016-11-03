<?php

namespace Instante\Tests\Doctrine\Migrations;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\Configuration as DbalConfiguration;
use Doctrine\ORM\Configuration as OrmConfiguration;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\DefaultQuoteStrategy;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;

function createTestEntityManager($modelDir = 'default', $sqlFile = NULL) {
    $config = new OrmConfiguration();
    $config->setMetadataDriverImpl(new AnnotationDriver(new AnnotationReader(), __DIR__ . '/model/'.$modelDir));
    $config->setNamingStrategy(new UnderscoreNamingStrategy());
    $config->setQuoteStrategy(new DefaultQuoteStrategy());
    $config->setProxyDir(TEMP_DIR . '/proxies');
    $config->setProxyNamespace('Instante\\Tests\\Doctrine\\Migrations\\Proxies');

    $conn = DriverManager::getConnection([
        'url' => 'sqlite://' . $sqlFile === NULL ? ':memory:' : ('/' . TEMP_DIR . "/$sqlFile.sqlite"),
        'driver' => 'pdo_sqlite',
    ], new DbalConfiguration());

    return EntityManager::create($conn, $config);
}
