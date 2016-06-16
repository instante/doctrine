<?php

namespace Instante\Tests\Doctrine\Users;

use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/mocks.php';

$u = new MockUser('u', 'p');
Assert::same(TRUE, $u->isActive());
Assert::false($u->checkPassword('f'));
Assert::true($u->checkPassword('p'));
$u->setPassword('new');
Assert::true($u->checkPassword('new'));
Assert::type('array', $u->getRoles());
