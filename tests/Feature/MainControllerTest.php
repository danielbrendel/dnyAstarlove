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

class MainControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testFaq()
    {
        $response = $this->get('/faq');

        $response->assertStatus(200);
        $response->assertViewIs('home.faq');
    }

    public function testNews()
    {
        $response = $this->get('/news');

        $response->assertStatus(200);
        $response->assertViewIs('home.news');
    }

    public function testTos()
    {
        $response = $this->get('/tos');

        $response->assertStatus(200);
        $response->assertViewIs('home.tos');
    }

    public function testImprint()
    {
        $response = $this->get('/imprint');

        $response->assertStatus(200);
        $response->assertViewIs('home.imprint');
    }

    public function testContact()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertViewIs('home.contact');
    }
}
