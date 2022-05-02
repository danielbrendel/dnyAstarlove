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

/**
 * Class LikeModel
 * 
 * Represents the like interface
 */
class LikeModel extends Model
{
    use HasFactory;

    /**
     * Like someone
     * 
     * @param $userId
     * @param $likedUserId
     * @return void
     * @throws \Exception
     */
    public static function add($userId, $likedUserId)
    {
        try {
            If (IgnoreModel::hasIgnored($likedUserId, $userId)) {
                throw new \Exception(__('app.user_ignored'));
            }

            if (static::hasLiked($userId, $likedUserId)) {
                throw new \Exception(__('app.already_liked'));
            }

            $exists = static::where('userId', '=', $userId)->where('likedUserId', '=', $likedUserId)->first();
            if ($exists) {
                return;
            }

            $item = new self();
            $item->userId = $userId;
            $item->likedUserId = $likedUserId;
            $item->save();

            $user = User::get($userId);

            PushModel::addNotification(__('app.like_received_short'), __('app.like_received_long', ['name' => $user->name, 'url_profile' => url('/user/' . $user->name), 'url_settings' => url('/settings?tab=likes')]), 'PUSH_LIKED', $likedUserId);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove like
     * 
     * @param $userId
     * @param $likedUserId
     * @return void
     * @throws \Exception
     */
    public static function remove($userId, $likedUserId)
    {
        try {
            $item = static::where('userId', '=', $userId)->where('likedUserId', '=', $likedUserId)->first();
            if (!$item) {
                throw new \Exception(__('app.user_not_yet_liked'));
            }

            $item->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if user has liked another one
     * 
     * @param $userId
     * @param $likedUserId
     * @return bool
     * @throws \Exception
     */
    public static function hasLiked($userId, $likedUserId)
    {
        try {
            $item = static::where('userId', '=', $userId)->where('likedUserId', '=', $likedUserId)->count();

            return $item === 1;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if the users mutually liked each other
     * 
     * @param $userId1
     * @param $userId2
     * @return bool
     * @throws \Exception
     */
    public static function bothLiked($userId1, $userId2)
    {
        try {
            return (static::hasLiked($userId1, $userId2)) && (static::hasLiked($userId2, $userId1));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Query received like list
     * 
     * @param $userId
     * @param $limit
     * @param $paginate
     * @return array
     * @throws \Exception
     */
    public static function queryReceivedLikes($userId, $limit, $paginate = null)
    {
        try {
            $query = static::where('likedUserId', '=', $userId);

            if ($paginate !== null) {
                $query->where('id', '<', $paginate);
            }

            return $query->orderBy('id', 'desc')->limit($limit)->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Query given like list
     * 
     * @param $userId
     * @param $limit
     * @param $paginate
     * @return array
     * @throws \Exception
     */
    public static function queryGivenLikes($userId, $limit, $paginate = null)
    {
        try {
            $query = static::where('userId', '=', $userId);

            if ($paginate !== null) {
                $query->where('id', '<', $paginate);
            }

            return $query->orderBy('id', 'desc')->limit($limit)->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
