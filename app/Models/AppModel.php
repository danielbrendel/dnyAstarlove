<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    use HasFactory;

    /**
     * Get application settings
     * 
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public static function getAppSettings($id = 1)
    {
        try {
            return static::where('id', '=', $id)->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get background image file name
     * 
     * @return string
     * @throws \Exception
     */
    public static function getBackground()
    {
        try {
            return static::getAppSettings()->backgroundImage;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get background alpha channel value
     * 
     * @return string
     * @throws \Exception
     */
    public static function getAlphaChannel()
    {
        try {
            return static::getAppSettings()->alphaChannel;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
