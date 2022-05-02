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
use App\Models\MailerModel;

class MailerModelTest extends TestCase
{
    public function testSendMail()
    {
        $this->markTestSkipped();

        $result = MailerModel::sendMail('test@domain.tld', md5(random_bytes(55)), md5(random_bytes(55)));

        $this->assertTrue($result);
    }
}
