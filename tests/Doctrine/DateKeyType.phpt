<?php

namespace Instante\Tests\Doctrine\Users;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\Type;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

$dateStr = '2004-02-12';


Type::addType('datekey', 'Instante\Doctrine\DateKeyType');
$platform = new MySqlPlatform();
$platform->registerDoctrineTypeMapping('datekey', 'datekey');
$platform->markDoctrineTypeCommented(Type::getType('datekey'));

$dateKeyType = Type::getType('datekey');
Assert::type('Instante\Doctrine\DateKeyType', $dateKeyType);
$date = $dateKeyType->convertToPHPValue($dateStr, $platform);
Assert::same($dateStr, $date->format('Y-m-d'));
