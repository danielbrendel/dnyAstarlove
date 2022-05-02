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

    public function testGetRegInfo()
    {
        $result = AppModel::getRegInfo();

        $this->assertIsString($result);
    }

    public function testGetCookieConsentText()
    {
        $result = AppModel::getCookieConsentText();

        $this->assertIsString($result);
    }

    public function testGetTermsOfService()
    {
        $result = AppModel::getTermsOfService();

        $this->assertIsString($result);
    }

    public function testGetImprint()
    {
        $result = AppModel::getImprint();

        $this->assertIsString($result);
    }

    public function testCreateTicket()
    {
        $this->markTestSkipped();
        
        $name = md5(random_bytes(55));
        $email = $name . '@domain.tld';
        $subject = md5(random_bytes(55));
        $text = md5(random_bytes(55));

        $result = AppModel::createTicket($name, $email, $subject, $text);
        $this->addToAssertionCount(1);
    }
}
