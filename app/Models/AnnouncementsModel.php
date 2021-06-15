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
use Illuminate\Support\Carbon;

/**
 * Class AnnouncementsModel
 * 
 * Interface to announcements
 */
class AnnouncementsModel extends Model
{
    use HasFactory;

    /**
     * Add new announcement
     * 
     * @param $title
     * @param $content
     * @param $duration
     * @return void
     * @throws \Exception
     */
    public static function add($title, $content, $duration)
    {
        try {
            $item = new self();
            $item->title = $title;
            $item->content = $content;
            $item->duration = $duration;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Query all current announcements
     * 
     * @return mixed
     * @throws \Exception
     */
    public static function queryAll()
    {
        try {
            $dateNow = Carbon::now();

            return static::where('until', '>=', $dateNow)->get();
        } catch (\Exceptions $e) {
            throw $e;
        }
    }
}
