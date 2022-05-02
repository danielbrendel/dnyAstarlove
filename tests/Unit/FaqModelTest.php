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
use App\Models\FaqModel;

class FaqModelTest extends TestCase
{
    public function testGetAll()
    {
        $result = FaqModel::getAll();

        $this->assertIsObject($result);
        foreach ($result as $item) {
            $this->assertTrue(isset($item->question));
            $this->assertTrue(isset($item->answer));
        }
    }
}
