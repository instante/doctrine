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

class AuthenticatorTest extends TestCase
{
    public function testAuthenticate()
    {
        $a = new Authenticator(new MockUserRepository);
        Assert::type('Instante\Tests\Doctrine\Users\MockUser', $a->authenticate(['user', 'pwd']));
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

run(new AuthenticatorTest);
