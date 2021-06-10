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
 * Class GuestbookModel
 *
 * Interface to guestbook
 */
class GuestbookModel extends Model
{
    use HasFactory;

    /**
     * Add entry to guestbook
     * 
     * @param $senderId
     * @param $receiverId
     * @param $content
     * @return void
     * @throws \Exception
     */
    public static function add($senderId, $receiverId, $content)
    {
        try {
            $item = new self();
            $item->senderId = $senderId;
            $item->receiverId = $receiverId;
            $item->content = \Purifier::clean($content);
            $item->edited = false;
            $item->save();

            $sender = User::get($senderId);

            PushModel::addNotification(__('app.guestbook_entry_short'), __('app.guestbook_entry_long', ['name' => $sender->name, 'url' => url('/user/' . $sender->name)]), 'PUSH_GUESTBOOK', $receiverId);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Edit guestbook entry
     * 
     * @param $id
     * @param $content
     * @return void
     * @throws \Exception
     */
    public static function edit($id, $content)
    {
        try {
            $item = static::where('id', '=', $id);

            if (!User::isAdmin(auth()->id())) {
                $item->where('senderId', '=', auth()->id());
            }

            $item = $item->first();

            if (!$item) {
                throw new \Exception('Item not found.');
            }

            $item->content = \Purifier::clean($content);
            $item->edited = true;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete a guestbook entry
     * 
     * @param $id
     * @return void
     * @throws \Exception
     */
    public static function remove($id)
    {
        try {
            $item = static::where('id', '=', $id);

            if (!User::isAdmin(auth()->id())) {
                $item->where('senderId', '=', auth()->id());
            }

            $item = $item->first();

            if (!$item) {
                throw new \Exception('Item not found.');
            }

            $item->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Fetch guestbook pack of user
     * 
     * @param $userId
     * @param $limit
     * @param $paginate
     * @return mixed
     * @throws \Exception
     */
    public static function fetchPack($userId, $limit, $paginate = null)
    {
        try {
            $query = static::where('receiverId', '=', $userId);

            if ($paginate !== null) {
                $query->where('id', '<', $paginate);
            }

            return $query->orderBy('id', 'desc')->limit($limit)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
