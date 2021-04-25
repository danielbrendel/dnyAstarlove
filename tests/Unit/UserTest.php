<?php

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
}
