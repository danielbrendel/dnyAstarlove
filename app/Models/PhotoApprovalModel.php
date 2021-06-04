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
use App\Models\User;
use App\Models\PushModel;

/**
 * Class PhotoApprovalModel
 * 
 * Photo approval management
 */
class PhotoApprovalModel extends Model
{
    use HasFactory;

    /**
     * Validate photo type
     * 
     * @param $which
     * @return void
     * @throws \Exception
     */
    protected static function validatePhotoType($which)
    {
        $photoTypes = array('avatar', 'photo1', 'photo2', 'photo3');

        if (!in_array($which, $photoTypes)) {
            throw new \Exception('Invalid photo type: ' . $which);
        }
    }

    /**
     * Add photo approval request
     * 
     * @param $userId
     * @param $which
     */
    public static function add($userId, $which)
    {
        try {
            static::validatePhotoType($which);

            $item = static::where('userId', '=', $userId)->where('which', '=', $which)->first();
            if (!$item) {
                $item = new self();
                $item->userId = $userId;
                $item->which = $which;
                $item->save();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if approval of photo is still pending
     * 
     * @param $userId
     * @param $which
     * @return bool
     * @throws \Exception
     */
    public static function isApprovalPending($userId, $which)
    {
        try {
            static::validatePhotoType($which);

            $count = static::where('userId', '=', $userId)->where('which', '=', $which)->count();

            return $count > 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Approve user photo
     * 
     * @param $userId
     * @param $which
     * @return void
     * @throws \Exception
     */
    public static function approve($userId, $which)
    {
        try {
            static::validatePhotoType($which);

            $item = static::where('userId', '=', $userId)->where('which', '=', $which)->first();
            if ($item) {
                PushModel::addNotification(__('app.approval_approved_short'), __('app.approval_approved_long'), 'PUSH_APPROVAL', $item->userId);

                $item->delete();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Decline user photo
     * 
     * @param $userId
     * @param $which
     * @return void
     * @throws \Exception
     */
    public static function decline($userId, $which)
    {
        try {
            static::validatePhotoType($which);

            $item = static::where('userId', '=', $userId)->where('which', '=', $which)->first();
            if ($item) {
                $user = User::get($userId);
                if ($user) {
                    $large = $which . '_large';

                    unlink(public_path() . '/gfx/avatars/' . $user->$which);
                    unlink(public_path() . '/gfx/avatars/' . $user->$large);

                    $user->$which = 'default.png';
                    $user->$large = 'default.png';
                    $user->save();
                }

                PushModel::addNotification(__('app.approval_declined_short'), __('app.approval_declined_long'), 'PUSH_APPROVAL', $item->userId);

                $item->delete();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Fetch approval pack
     * 
     * @param $limit
     * @return mixed
     * @throws \Exception
     */
    public static function fetchPack($limit)
    {
        try {
            $approvals = static::orderBy('id', 'asc')->limit($limit)->get();

            foreach ($approvals as $key => &$approval) {
                $user = User::get($approval->userId);
                if (!$user) {
                    $approval->delete();
                    unset($approvals[$key]);
                } else {
                    $approval->user = $user;
                }
            }

            return $approvals;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
