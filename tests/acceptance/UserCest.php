<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class UserCest
{
    public function testUsersInDb(AcceptanceTester $I)
    {
        $I->seeInRepository('App\Entity\User', [
            'email' => 'user@user.com'
        ]);
    }

    public function testAddToDatabase(AcceptanceTester $I)
    {
        // INSERT new user `userTemp@temp.com` into the User table
        $I->haveInRepository('App\Entity\User', [
            'email' => 'userTemp@temp.com',
            'password' => 'simplepassword',
            'roles' => ['ROLE_USER']
        ]);

        // test whether user `userTemp@temp.com`  can be FOUND in the table
        $I->seeInRepository('App\Entity\User', [
            'email' => 'userTemp@temp.com',
        ]);
    }

    public function testTEMPNoLongerInDatabase(AcceptanceTester $I)
    {
        // since we are RESETTING db after each test, the temporary user should NOT still be in
        $I->dontSeeInRepository('App\Entity\User', [
            'email' => 'userTemp@temp.com',
        ]);
    }
}
