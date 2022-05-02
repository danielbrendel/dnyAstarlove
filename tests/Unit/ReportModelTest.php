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
use App\Models\ReportModel;

class ReportModelTest extends TestCase
{
    public function testProcedure()
    {
        $reporterId  = 1;
        $targetId = 2;

        ReportModel::add($reporterId, $targetId);
        $this->addToAssertionCount(1);

        $result = ReportModel::hasReported($reporterId, $targetId);
        $this->assertTrue($result);

        $result = ReportModel::getReportPack();
        $this->assertIsObject($result);
        foreach ($result as $item) {
            $this->assertTrue(isset($item->reporterId));
            $this->assertTrue(isset($item->targetId));
        }

        ReportModel::setSafe($targetId);
        $this->addToAssertionCount(1);

        $result = ReportModel::hasReported($reporterId, $targetId);
        $this->assertFalse($result);
    }
}
