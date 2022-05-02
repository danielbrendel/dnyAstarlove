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
 * Class FaqModel
 * 
 * Represents interface to FAQ
 */
class FaqModel extends Model
{
    use HasFactory;

    /**
     * Get all FAQ items
     *
     * @return FaqModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return static::all();
    }
}
