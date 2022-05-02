<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MessageModel;

class MessageModelTest extends TestCase
{
    public function testAdd()
    {
        $userId = 1;
        $senderId = 2;
        $subject = md5(random_bytes(55));
        $message = md5(random_bytes(55));

        MessageModel::add($userId, $senderId, $subject, $message);
        $this->addToAssertionCount(1);

        $item = MessageModel::where('subject', '=', $subject)->where('message', '=', '<p>' . $message . '</p>')->where('userId', '=', $userId)->where('senderId', '=', $senderId)->first();
        $this->assertIsObject($item);
        $this->assertTrue(isset($item->channel));
    }

    public function testFetch()
    {
        $userId = 1;

        $result = MessageModel::fetch($userId, 10, null);

        $this->assertIsObject($result);

        foreach ($result as $item) {
            $this->assertTrue(isset($item->subject));
            $this->assertTrue(isset($item->message));
        }
    }

    public function testGetMessageThread()
    {
        $msgId = 1;

        $result = MessageModel::getMessageThread($msgId);

        $this->assertIsArray($result);
        $this->assertTrue(isset($result['msg']));
        $this->assertTrue(isset($result['previous']));
    }

    public function testUnreadCount()
    {
        $userId = 1;

        $result = MessageModel::unreadCount($userId);
        $this->assertIsInt($result);
    }
}
