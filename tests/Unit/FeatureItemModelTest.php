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
use App\Models\FeatureItemModel;

class FeatureItemModelTest extends TestCase
{
    public function testGetItem()
    {
        $itemId = 1;

        $result = FeatureItemModel::getItem($itemId);

        $this->assertIsObject($result);
        $this->assertTrue(isset($result->title));
        $this->assertTrue(isset($result->description));
    }

    public function testGetAll()
    {
        $result = FeatureItemModel::getAll();

        $this->assertIsObject($result);

        foreach ($result as $item) {
            $this->assertTrue(isset($item->title));
            $this->assertTrue(isset($item->description));
        }
    }

    public function testAdd()
    {
        $title = md5(random_bytes(55));
        $description = md5(random_bytes(55));

        FeatureItemModel::add($title, $description);
        $this->addToAssertionCount(1);

        $item = FeatureItemModel::where('title', '=', $title)->first();
        
        $this->assertEquals($item->title, $title);
        $this->assertEquals($item->description, $description);

        return $item->id;
    }

    /**
     * @depends testAdd
     */
    public function testEdit($id)
    {
        $title = md5(random_bytes(55));
        $description = md5(random_bytes(55));

        FeatureItemModel::edit($id, $title, $description);
        $this->addToAssertionCount(1);

        $item = FeatureItemModel::where('id', '=', $id)->first();

        $this->assertEquals($item->title, $title);
        $this->assertEquals($item->description, $description);

        return $id;
    }

    /**
     * @depends testEdit
     */
    public function testRemove($id)
    {
        FeatureItemModel::remove($id);
        $this->addToAssertionCount(1);

        $item = FeatureItemModel::where('id', '=', $id)->first();

        $this->assertTrue(is_null($item));
    }
}
