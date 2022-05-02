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
use App\Models\VisitorModel;

class VisitorModelTest extends TestCase
{
    public function testProcedure()
    {
        $visitorId = 1;
        $visitedId = 2;

        VisitorModel::add($visitorId, $visitedId);
        $this->addToAssertionCount(1);

        $result = VisitorModel::hasVisited($visitorId, $visitedId);
        $this->assertTrue($result);

        $result = VisitorModel::getVisitorPack($visitedId, 10, null);
        $this->assertIsArray($result);

        foreach ($result as $item) {
            $this->assertTrue(isset($item['visitorId']));
            $this->assertTrue(isset($item['visitedId']));
            $this->assertTrue(isset($item['seen']));
        }

        VisitorModel::where('visitorId', '=', $visitorId)->where('visitedId', '=', $visitedId)->first()->delete();
        $result = VisitorModel::hasVisited($visitorId, $visitedId);
        $this->assertFalse($result);
    }
}
