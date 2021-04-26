<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FeatureItemModel
 *
 * Interface to feature items
 */
class FeatureItemModel extends Model
{
    use HasFactory;


    /**
     * Get specific item
     * 
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public static function getItem($id)
    {
        try {
            return static::where('id', '=', $id)->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get all items
     * 
     * @return mixed
     * @throws \Exception
     */
    public static function getAll()
    {
        try {
            return static::all();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Add new item
     * 
     * @param $title
     * @param $description
     * @return void
     * @throws \Exception
     */
    public static function add($title, $description)
    {
        try {
            $item = new self();
            $item->title = $title;
            $item->description = $description;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Edit specific item
     * 
     * @param $id
     * @param $title
     * @param $description
     * @return void
     * @throws \Exception
     */
    public static function edit($id, $title, $description)
    {
        try {
            $item = static::where('id', '=', $id)->first();
            if (!$item) {
                throw new \Exception('Element not found: ' . $id);
            }

            $item->title = $title;
            $item->description = $description;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete specific item
     * 
     * @param $id
     * @return void
     * @throws \Exception
     */
    public static function remove($id)
    {
        try {
            $item = static::where('id', '=', $id)->first();
            if (!$item) {
                throw new \Exception('Element not found: ' . $id);
            }

            $item->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
