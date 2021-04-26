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
use App\Models\PushModel;

class PushModelTest extends TestCase
{
    public function testAddNotification()
    {
        $userId = 1;
        $shortMsg = md5(random_bytes(55));
        $longMsg = md5(random_bytes(55));
        $type = 'PUSH_VISITED';

        PushModel::addNotification($shortMsg, $longMsg, $type, $userId);

        $this->addToAssertionCount(1);
    }

    public function testHasUnseenNotifications()
    {
        $userId = 1;

        $result = PushModel::hasUnseenNotifications($userId);
        $this->assertTrue($result === true || $result === false);
    }

    public function testGetUnseenNotifications()
    {
        $userId = 1;

        $result = PushModel::getUnseenNotifications($userId);

        $this->assertIsObject($result);

        foreach ($result as $item) {
            $this->assertTrue(isset($item->longMsg));
            $this->assertTrue(isset($item->shortMsg));
        }
    }

    public function testGetNotifications()
    {
        $userId = 1;

        $result = PushModel::getNotifications($userId, 10, null);

        $this->assertIsObject($result);

        foreach ($result as $item) {
            $this->assertTrue(isset($item->longMsg));
            $this->assertTrue(isset($item->shortMsg));
        }
    }
}
