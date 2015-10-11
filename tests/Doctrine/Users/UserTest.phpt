<?php

namespace Instante\Tests\Doctrine\Users;

use Doctrine\Common\Persistence\ObjectRepository;
use Instante\Doctrine\Users\Authenticator;
use Instante\Doctrine\Users\User;
use Tester\Assert;
use Tester\TestCase;
use Nette\Security\AuthenticationException;
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/mocks.php';

$u = new MockUser('u', 'p');
Assert::same(1, $u->isActive());
Assert::false($u->checkPassword('f'));
Assert::true($u->checkPassword('p'));
$u->setPassword('new');
Assert::true($u->checkPassword('new'));
Assert::type('array', $u->getRoles());