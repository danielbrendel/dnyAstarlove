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
 * Class IgnoreModel
 *
 * Manages ignore functionality
 */
class IgnoreModel extends Model
{
    use HasFactory;

    /**
     * Add to ignore list
     *
     * @param $userId
     * @param $targetId
     * @throws \Exception
     */
    public static function add($userId, $targetId)
    {
        try {
            if (User::isAdmin($targetId)) {
                return;
            }

            $exists = static::where('userId', '=', $userId)->where('targetId', '=', $targetId)->count();
            if ($exists === 0) {
                $item = new self();
                $item->userId = $userId;
                $item->targetId = $targetId;
                $item->save();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove from ignore list
     *
     * @param $userId
     * @param $targetId
     * @throws \Exception
     */
    public static function remove($userId, $targetId)
    {
        try {
            $exists = static::where('userId', '=', $userId)->where('targetId', '=', $targetId)->first();
            if ($exists) {
                $exists->delete();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if a user has ignored another user
     *
     * @param $userId
     * @param $targetId
     * @return bool
     * @throws \Exception
     */
    public static function hasIgnored($userId, $targetId)
    {
        try {
            return $exists = static::where('userId', '=', $userId)->where('targetId', '=', $targetId)->count() > 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get ignore list of a user
     * 
     * @param $userId
     * @param $limit
     * @param $paginate
     * @return array
     * @throws \Exception
     */
    public static function getIgnorePack($userId, $limit, $paginate = null)
    {
        try {
            $query = static::where('userId', '=', $userId);

            if ($paginate !== null) {
                $query->where('id', '<', $paginate);
            }

            $query->orderBy('id', 'desc')->limit($limit);

            return $query->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
