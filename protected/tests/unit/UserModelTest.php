<?php

/**
 * Tests for the User model
 */
class UserModelTest extends CDbTestCase
{
    public $fixtures = [
        'user' => 'User'
    ];

    /**
     * Tests bylogin fetching
     *
     * @return void
     */
    public function testGetUserByLogin()
    {
        $login = 'someCoolTestName';
        $user = new User('registration');

        $user->attributes = [
            'email' => 'test@phpguide.co.il',
            'password' => 'pass',
            'login' => $login
        ];

        $user->ip = '127.0.0.1';
        $user->salt = 'abc';

        $user->save(true);

        $userByLogin = User::model()->getUserByLogin($login);

        $this->assertEquals($user->id, $userByLogin->id);
        $this->assertEquals($user->email, $userByLogin->email);

    }


    /**
     * Test points counter updating
     *
     * @return void
     */
    public function testUpdatePointsBy()
    {

        $login = 'someCoolTestName';
        $user = new User('registration');

        $user->attributes = [
            'email' => 'test@phpguide.co.il',
            'password' => 'pass',
            'login' => $login
        ];

        $user->ip = '127.0.0.1';
        $user->salt = 'abc';

        $user->save(true);
        $this->assertEquals(0, $user->points);

        $user->updatePointsBy(10);
        $this->assertEquals(10, $user->points);

        $user->updatePointsBy(-20);
        $this->assertEquals(-10, $user->points);

    }
}