<?php

namespace Instante\Tests\Doctrine\Users;

use Instante\Doctrine\Users\User;
use Instante\Doctrine\Users\UserStorage;
use Nette\Security\Identity;
use Tester\Assert;
use Tester\Environment;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/mocks.php';

if (PHP_VERSION_ID === 70000) {
    Environment::skip('session mocking is broken on PHP 7.0.0 due to bug #70520');
}

$mockUserRepository = new FakeUserRepository;
$sess = MockSessionFactory::create();
$mockUserRepository->users[10] = createFakeUser('u', 'pwd');
$userSess = $sess->getSection('Nette.Http.UserStorage/');
$userSess->identity = new Identity(10);
$userSess->authenticated = TRUE;

$userStorage = new UserStorage($mockUserRepository, $sess);



Assert::true($userStorage->getIdentity()->checkPassword('pwd'));

$u = createFakeUser('user', 'pass');
$refl = new \ReflectionClass(User::class);
$idProp = $refl->getProperty('id');
$idProp->setAccessible(TRUE);
$idProp->setValue($u, 15);
$userStorage->setIdentity($u);

Assert::equal(15, $userSess->identity->getId());
