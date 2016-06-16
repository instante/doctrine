<?php

namespace Instante\Tests\Doctrine\Users;

use Instante\Doctrine\Users\Authenticator;
use Nette\Security\AuthenticationException;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/mocks.php';

class AuthenticatorTest extends TestCase
{
    public function testAuthenticate()
    {
        $a = new Authenticator(new MockUserRepository);
        Assert::type(MockUser::class, $a->authenticate(['user', 'pwd']));
        Assert::throws(function () use ($a) {
            $a->authenticate([
                'user',
                'pass',
            ]);
        }, AuthenticationException::class, NULL, Authenticator::INVALID_CREDENTIAL);
        Assert::throws(function () use ($a) {
            $a->authenticate([
                'usr',
                'pwd',
            ]);
        }, AuthenticationException::class, NULL, Authenticator::IDENTITY_NOT_FOUND);
        Assert::throws(function () use ($a) {
            $a->authenticate([
                'inact',
                'pwd',
            ]);
        }, AuthenticationException::class, NULL, Authenticator::NOT_APPROVED);
    }
}

(new AuthenticatorTest)->run();
