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
use App\Models\IgnoreModel;

class IgnoreModelTest extends TestCase
{
    public function testIgnoreProcess()
    {
        $userId = 1;
        $targetId = 2;

        IgnoreModel::add($userId, $targetId);
        $this->addToassertionCount(1);

        $ignored = IgnoreModel::hasIgnored($userId, $targetId);
        $this->assertTrue($ignored);

        IgnoreModel::remove($userId, $targetId);
        $this->addToAssertionCount(1);

        $ignored = IgnoreModel::hasIgnored($userId, $targetId);
        $this->assertFalse($ignored);
    }
}
