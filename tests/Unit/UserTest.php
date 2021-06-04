<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function testGetLastRegisteredMembers()
    {
        $result = User::getLastRegisteredMembers(10);

        $this->assertIsObject($result);
        foreach ($result as $user) {
            $this->assertTrue(isset($user->name));
        }
    }

    public function testIsMemberOnline()
    {
        $userId = 1;

        $user = User::where('id', '=', $userId)->first();
        $user->last_action = '1970-01-01 00:00:00';
        $user->save();

        $result = User::isMemberOnline($userId);
        $this->assertFalse($result);

        $user->last_action = date('Y-m-d H:i:s');
        $user->save();

        $result = User::isMemberOnline($userId);
        $this->assertTrue($result);
    }

    public function testRegister()
    {
        $this->markTestSkipped();

        $name = md5(random_bytes(55));
        $email = $name . '@domain.tld';
        $password = 'test';
        $password_confirm = $password;

        $id = User::register([
            'username' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirm,
            'captcha' => null
        ]);

        $this->assertTrue($id > 0);

        $user = User::where('id', '=', $id)->first();

        $this->assertIsObject($user);
        $this->assertTrue(isset($user->name));
        $this->assertTrue(isset($user->email));
    }

    public function testQueryProfiles()
    {
        $this->markTestSkipped();

        $result = User::queryProfiles(1000, 1, 1, 1, 1, 1, 1, 18, 100, 0, 0, null);

        $this->assertIsArray($result);
        
        foreach ($result as $item) {
            $this->assertTrue(isset($item->name));
            $this->assertTrue(isset($item->avatar));
            $this->assertTrue(isset($item->is_online));
        }
    }

    public function testStoreGeoLocation()
    {
        $this->markTestSkipped();

        $latitude = '10.000000';
        $longitude = '5.000000';

        $result = User::storeGeoLocation($latitude, $longitude);
        $this->addToAssertionCount(1);
    }
}
