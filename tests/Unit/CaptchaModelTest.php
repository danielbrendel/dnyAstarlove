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
use App\Models\CaptchaModel;

class CaptchaModelTest extends TestCase
{
    private $session_id;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session_id = 'test_' . md5(random_bytes(55));
    }

    public function testCreateSum()
    {
        $result = CaptchaModel::createSum($this->session_id);

        $this->assertIsArray($result);
        $this->assertTrue($result[0] >= 0);
        $this->assertTrue($result[0] <= 10);
        $this->assertTrue($result[1] >= 0);
        $this->assertTrue($result[1] <= 10);

        return $result;
    }

    /**
     * @depends testCreateSum
     */
    public function testQuerySum($captchadata)
    {
        $this->markTestSkipped();

        $result = CaptchaModel::querySum($this->session_id);

        $this->assertEquals($result, $captchadata[0] + $captchadata[1]);
    }
}
