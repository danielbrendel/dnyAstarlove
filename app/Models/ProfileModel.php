<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProfileModel
 *
 * Represents the interface to profile item definitions
 */
class ProfileModel extends Model
{
    use HasFactory;

    /**
     * Add new profile item
     *
     * @param $name
     * @param $translation
     * @param $locale
     * @return void
     * @throws Exception
     */
    public static function add($name, $translation, $locale)
    {
        try {
            $item = new self();
            $item->name = $name;
            $item->translation = $translation;
            $item->locale = $locale;
            $item->active = true;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Edit a profile item
     *
     * @param $id
     * @param $name
     * @param $translation
     * @param $locale
     * @param $active
     * @return void
     * @throws Exception
     */
    public static function edit($id, $name, $translation, $locale, $active)
    {
        try {
            $item = static::where('id', '=', $id)->first();
            if (!$item) {
                throw new \Exception('Item not found: ' . $id);
            }

            $item->name = $name;
            $item->translation = $translation;
            $item->locale = $locale;
            $item->active = $active;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove an item
     *
     * @param $id
     * @return void
     * @throws Exception
     */
    public static function remove($id)
    {
        try {
            $item = static::where('id', '=', $id)->first();
            if (!$item) {
                throw new \Exception('Item not found: ' . $id);
            }
            $item->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get item translation
     *
     * @param $name
     * @return string
     * @throws Exception
     */
    public static function getTranslation($name)
    {
        try {
            $item = static::where('name', '=', $name)->where('locale', '=', \App::getLocale())->where('active', '=', true)->first();
            if (!$item) {
                return null;
            }

            return $item->translation;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get list of items
     *
     * @return mixed
     * @throws Exception
     */
    public static function getList()
    {
        try {
            return static::where('locale', '=', \App::getLocale())->where('active', '=', true)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
