<?php

namespace Instante\Tests\Doctrine\Users;

use Doctrine\Common\Persistence\ObjectRepository;
use Instante\Doctrine\Users\Authenticator;
use Instante\Doctrine\Users\User;
use Instante\Doctrine\Users\UserStorage;
use Nette\Security\Identity;
use Tester\Assert;
use Tester\Environment;
use Tester\TestCase;
use Nette\Security\AuthenticationException;
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/mocks.php';

if (PHP_VERSION_ID === 70000) {
    Environment::skip('session mocking is broken on PHP 7.0.0 due to bug #70520');
}

$userStorage = new UserStorage($mockUserRepository = new MockUserRepository, $sess = MockSessionFactory::create());
$mockUserRepository->users[10] = new MockUser('u', 'pwd');
$userSess = $sess->getSection('Nette.Http.UserStorage/');
$userSess->identity = new Identity(10);
$userSess->authenticated = TRUE;


Assert::true($userStorage->getIdentity()->checkPassword('pwd'));

$u = new MockUser('user', 'pass');
$refl = new \ReflectionClass(User::class);
$idProp = $refl->getProperty('id');
$idProp->setAccessible(TRUE);
$idProp->setValue($u, 15);
$userStorage->setIdentity($u);

Assert::equal(15, $userSess->identity->getId());