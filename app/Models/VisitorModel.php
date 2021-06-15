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
use App\Models\PushModel;
use App\Models\User;

/**
 * Class VisitorModel
 * 
 * Interface to visitor management
 */
class VisitorModel extends Model
{
    use HasFactory;

    /**
     * Add visitor
     * 
     * @param $visitorId
     * @param $visitedId
     * @return void
     * @throws \Exception
     */
    public static function add($visitorId, $visitedId)
    {
        try {
            $item = null;

            $exists = static::where('visitorId', '=', $visitorId)->where('visitedId', '=', $visitedId)->first();
            if ($exists) {
                if (!$exists->seen) {
                    $exists->touch();
                    return;
                }
                
                $item = $exists;
            } else {
                $item = new self();
                $item->visitorId = $visitorId;
                $item->visitedId = $visitedId;
            }

            $item->seen = false;
            $item->save();
            
            $visitedData = User::get($visitedId);
            if ($visitedData->info_profile_visit) {
                $userData = User::get($visitorId);
                PushModel::addNotification(__('app.user_visited_short'), __('app.user_visited_long', ['name' => $userData->name, 'url' => url('/user/' . $userData->name), 'visitors' => url('/settings?tab=visitors')]), 'PUSH_VISITED', $visitedId);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if user has visited another user
     * 
     * @param $visitorId
     * @param $visitedId
     * @return bool
     * @throws \Exception
     */
    public static function hasVisited($visitorId, $visitedId)
    {
        try {
            $exists = static::where('visitorId', '=', $visitorId)->where('visitedId', '=', $visitedId)->count();

            return $exists === 1;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get visitors pack of a user
     * 
     * @param $userId
     * @param $limit
     * @param $paginate
     * @return array
     * @throws \Exception
     */
    public static function getVisitorPack($userId, $limit, $paginate = null)
    {
        try {
            $query = static::where('visitedId', '=', $userId);

            if ($paginate !== null) {
                $query->where('updated_at', '<', $paginate);
            }

            $query->orderBy('updated_at', 'desc')->limit($limit);

            $data = $query->get();

            foreach ($data as &$item) {
                $isNew = !$item->seen;

                if (!$item->seen) {
                    $item->seen = true;
                    $item->save();
                }

                $item->new = $isNew;
            }

            return $data->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get unseen visitor count
     * 
     * @param $userId
     * @return int
     * @throws \Exception
     */
    public static function getUnseenCount($userId)
    {
        try {
            return static::where('visitedId', '=', $userId)->where('seen', '=', false)->count();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
