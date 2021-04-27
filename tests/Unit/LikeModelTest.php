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
use App\Models\LikeModel;

class LikeModelTest extends TestCase
{
    public function testProcedure()
    {
        $userId  = 1;
        $likedUserId = 2;

        LikeModel::add($userId, $likedUserId);
        LikeModel::add($likedUserId, $userId);
        $this->addToAssertionCount(2);

        $result = LikeModel::hasLiked($userId, $likedUserId);
        $this->assertTrue($result);

        $result = LikeModel::bothLiked($userId, $likedUserId);
        $this->assertTrue($result);

        LikeModel::remove($userId, $likedUserId);
        LikeModel::remove($likedUserId, $userId);
        $this->addToAssertionCount(2);

        $result = LikeModel::hasLiked($userId, $likedUserId);
        $this->assertFalse($result);
    }
}
