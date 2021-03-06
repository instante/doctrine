<?php

/**
 * Tests usage of other authentication column name in Authenticator
 */

namespace Instante\Tests\Doctrine\Users;

use Instante\Doctrine\Users\Authenticator;
use Instante\Doctrine\Users\User;
use Nette\Security\AuthenticationException;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/mocks.php';

$a = new Authenticator(new FakeUserRepository, 'email');
Assert::type(User::class, $a->authenticate(['john.doe@example.com', 'pwd']));
Assert::throws(function () use ($a) {
    $a->authenticate(['user', 'pwd']);
}, AuthenticationException::class, NULL, Authenticator::IDENTITY_NOT_FOUND);
