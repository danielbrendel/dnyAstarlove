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
use App\Models\IgnoreModel;
use App\Models\LikeModel;

/**
 * Class FavoritesModel
 * 
 * Favorite management
 */
class FavoritesModel extends Model
{
    use HasFactory;

    /**
     * Add to favorites
     * 
     * @param $userId
     * @param $favoriteId
     * @return void
     * @throws \Exception
     */
    public static function add($userId, $favoriteId)
    {
        try {
            if (IgnoreModel::hasIgnored($favoriteId, $userId)) {
                throw new \Exception('User is ignore by favorite');
            }

            if (!LikeModel::bothLiked($userId, $favoriteId)) {
                throw new \Exception('Both are not liking each other');
            }

            $item = static::where('userId', '=', $userId)->where('favoriteId', '=', $favoriteId)->first();
            if ($item) {
                throw new \Exception('Already added to favorites');
            }

            $item = new self();
            $item->userId = $userId;
            $item->favoriteId = $favoriteId;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove from favorites
     * 
     * @param $userId
     * @param $favoriteId
     * @return void
     * @throws \Exception
     */
    public static function remove($userId, $favoriteId)
    {
        try {
            $item = static::where('userId', '=', $userId)->where('favoriteId', '=', $favoriteId)->first();
            if ($item) {
                $item->delete();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Fetch favorite pack
     * 
     * @param $userId
     * @param $limit 
     * @param $paginate
     * @return mixed
     * @throws \Exception
     */
    public static function fetch($userId, $limit, $paginate = null)
    {
        try {
            $query = static::where('userId', '=', $userId);

            if ($paginate !== null) {
                $query->where('id', '<', $paginate);
            }

            return $query->orderBy('id', 'desc')->limit($limit)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Indicate if user has added another user to their favorites
     * 
     * @param $userId
     * @param $favoriteId
     * @return bool
     * @throws \Exception
     */
    public static function hasFavorited($userId, $favoriteId)
    {
        try {
            $count = static::where('userId', '=', $userId)->where('favoriteId', '=', $favoriteId)->count();

            return $count > 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
