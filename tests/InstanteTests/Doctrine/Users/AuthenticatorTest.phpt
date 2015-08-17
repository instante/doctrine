<?php

namespace InstanteTests\Doctrine\Users;

use Doctrine\Common\Persistence\ObjectRepository;
use Instante\Doctrine\Users\Authenticator;
use Instante\Doctrine\Users\User;
use Tester\Assert;
use Tester\TestCase;
use Nette\Security\AuthenticationException;
require_once __DIR__ . '/../../bootstrap.php';

class AuthenticatorTest extends TestCase
{
    public function testAuthenticate()
    {
        $a = new Authenticator(new MockUserRepository);
        Assert::type('InstanteTests\Doctrine\Users\MockUser', $a->authenticate(['user', 'pwd']));
        Assert::throws(function () use ($a) {
            $a->authenticate([
                'user',
                'pass',
            ]); }, 'Nette\Security\AuthenticationException', NULL, Authenticator::INVALID_CREDENTIAL);
        Assert::throws(function () use ($a) {
            $a->authenticate([
                'usr',
                'pwd',
            ]); }, 'Nette\Security\AuthenticationException', NULL, Authenticator::IDENTITY_NOT_FOUND);
        Assert::throws(function () use ($a) {
            $a->authenticate([
                'inact',
                'pwd',
            ]); }, 'Nette\Security\AuthenticationException', NULL, Authenticator::NOT_APPROVED);
    }
}

class MockUser extends User
{
}

class MockUserRepository implements ObjectRepository
{
    public function find($id) { }

    public function findAll() { }

    public function findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL) { }

    public function findOneBy(array $criteria)
    {
        $mu = new MockUser('user', 'pwd');
        switch ($criteria['name']) {
            case 'inact':
                $mu->setActive(FALSE);
            case 'user': //intentional fallthru
                return $mu;
            default:
                return NULL;
        }
    }

    public function getClassName() { }
}

run(new AuthenticatorTest);
