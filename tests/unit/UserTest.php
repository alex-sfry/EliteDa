<?php

namespace Unit;

use app\models\ar\User;
use app\tests\fixtures\UserFixture;
use UnitTester;

class UserTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    public function _fixtures()
    {
        return [
            'users' => UserFixture::class,
        ];
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testFindUserById()
    {
        $this->tester->grabFixture('users');

        verify($user = User::findIdentity(2))->notEmpty();
        verify($user->username)->equals('user1');

        verify(User::findIdentity(999))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = User::findByUsername('user3'))->notEmpty();
        verify(User::findByUsername('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = User::findByUsername('user1');
        verify($user->validateAuthKey('test100key'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('admin'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();
    }

    // public function testFindUserByAccessToken()
    // {
    //     verify($user = User::findIdentityByAccessToken('100-token'))->notEmpty();
    //     verify($user->username)->equals('admin');

    //     verify(User::findIdentityByAccessToken('non-existing'))->empty();        
    // }
}
