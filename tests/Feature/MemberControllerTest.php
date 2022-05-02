<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->post('/login', [
            'email' => 'test@domain.tld',
            'password' => 'test'
        ]);
    }

    public function testProfiles()
    {
        $this->markTestSkipped();
        
        $response = $this->get('/profiles');

        $response->assertStatus(200);
        $response->assertViewIs('member.profiles');
    }

    public function testNameValidity()
    {
        $username = md5(random_bytes(55));

        $response = $this->get('/member/name/valid?ident=' . $username);

        $response->assertStatus(200);
        $content = json_decode($response->getContent());
        $this->assertTrue(isset($content->data->username));
        $this->assertTrue(isset($content->data->available));
        $this->assertTrue(isset($content->data->valid));
    }

    public function testQueryProfiles()
    {
        $this->markTestSkipped();

        $response = $this->post('/profiles/query', []);

        $response->assertStatus(200);
        $content = json_decode($response->getContent());
        $this->assertEquals($content->code, 200);
        $this->assertIsArray($content->data);
    }
}
