<?php

namespace Instante\Tests\Doctrine\Migrations;

use Instante\Doctrine\Migrations\IMigrationCodeStrategy;
use Instante\Doctrine\Migrations\IVersionNamingStrategy;
use Instante\Doctrine\Migrations\SchemaFileMigrationStrategy;
use Mockery;
use Tester\Assert;

function migrationExists() {
    return count(glob(TEMP_DIR . '/migrations/Version*.php')) > 0;
}
function schemaFilePath() {
    return TEMP_DIR . '/migrations/schema.php';
}

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/testEmFactory.php';

$versionNamingStrategy = Mockery::mock(IVersionNamingStrategy::class);
$migrationCodeStrategy = Mockery::mock(IMigrationCodeStrategy::class);

$em = createTestEntityManager();
$mg = new SchemaFileMigrationStrategy($em, $versionNamingStrategy, $migrationCodeStrategy, TEMP_DIR . '/migrations');
Assert::false(migrationExists());
Assert::false(is_file(schemaFilePath()));
$mg->createMigration();
Assert::true(migrationExists());
Assert::true(is_file(schemaFilePath()));

