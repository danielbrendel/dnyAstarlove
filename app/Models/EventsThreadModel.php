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
use App\Models\EventsModel;
use App\Models\User;

/**
 * Class EventsThreadModel
 * 
 * Represents interface to events message thread
 */
class EventsThreadModel extends Model
{
    use HasFactory;

    /**
     * Add message to event
     * 
     * @param $eventId
     * @param $message
     * @return void
     * @throws \Exception
     */
    public static function add($eventId, $message)
    {
        try {
            $event = EventsModel::where('id', '=', $eventId)->first();
            if (!$event) {
                throw new \Exception('Event not found: ' . $eventId);
            }

            $item = new self();
            $item->eventId = $eventId;
            $item->userId = auth()->id();
            $item->content = \Purifier::clean($message);
            $item->edited = false;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Edit a message
     * 
     * @param $messageId
     * @param $message
     * @return void
     * @throws \Exception
     */
    public static function edit($messageId, $message)
    {
        try {
            $msg = static::where('id', '=', $messageId)->first();
            if (!$msg) {
                throw new \Exception('Message not found: ' . $messageId);
            }

            $user = User::getByAuthId();
            if ((!$user->admin) || ($user->id !== $msg->userId)) {
                throw new \Exception('Insufficient permissions');
            }

            $msg->content = \Purifier::clean($message);
            $msg->edited = true;
            $msg->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove a message
     * 
     * @param $messageId
     * @return void
     * @throws \Exception
     */
    public static function remove($messageId)
    {
        try {
            $msg = static::where('id', '=', $messageId)->first();
            if (!$msg) {
                throw new \Exception('Message not found: ' . $messageId);
            }

            $user = User::getByAuthId();
            if ((!$user->admin) || ($user->id !== $msg->userId)) {
                throw new \Exception('Insufficient permissions');
            }

            $msg->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Fetch comment pack
     * 
     * @param $eventId
     * @param $limit
     * @param $paginate
     * @return mixed
     * @throws \Exception
     */
    public static function fetch($eventId, $limit, $paginate = null)
    {
        try {
            $query = static::where('eventId', '=', $eventId);

            if ($paginate !== null) {
                $query->where('id', '<', $paginate);
            }

            $data = $query->orderBy('id', 'desc')->limit($limit)->get();

            foreach ($data as &$item) {
                $item->sender = User::get($item->userId);
            }

            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
