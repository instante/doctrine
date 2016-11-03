<?php

namespace Instante\Tests\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\Tools\SchemaTool;
use Instante\Doctrine\Migrations\SchemaExporter;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/testEmFactory.php';

$em = createTestEntityManager('SchemaExporter.export');
$schemaExporter = new SchemaExporter();
$code = $schemaExporter->export($em);

Assert::type('string', $code);
$namingStrategy = $em->getConfiguration()->getNamingStrategy(); // set for the eval'd code

$result = eval(substr($code, 5));
$schemaTool = new SchemaTool($em);
$schema = $schemaTool->getSchemaFromMetadata($result);

Assert::type(Schema::class, $schema);
$dogTable = $schema->getTable('dog');
Assert::type(Table::class, $dogTable);
$catTable = $schema->getTable('cat');
Assert::type(Table::class, $catTable);
Assert::type(IntegerType::class, $catTable->getColumn('meows_per_second')->getType());
