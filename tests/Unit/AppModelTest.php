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
use App\Models\AppModel;

class AppModelTest extends TestCase
{
    public function testGetAppSettings()
    {
        $result = AppModel::getAppSettings();

        $this->assertIsObject($result);
        $this->assertTrue(isset($result->headline));
    }

    public function testGetBackground()
    {
        $result = AppModel::getBackground();

        $this->assertIsString($result);
        $this->assertTrue(file_exists(public_path() . '/gfx/backgrounds/' . $result));
    }

    public function testGetAlphaChannel()
    {
        $result = AppModel::getAlphaChannel();

        $this->assertIsString($result);
    }
}
