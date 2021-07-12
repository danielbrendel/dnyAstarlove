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
use App\Models\EventsModel;

/**
 * Class EventsParticipantsModel
 * 
 * Represents interface to events participants
 */
class EventsParticipantsModel extends Model
{
    use HasFactory;

    private static function validateType($type)
    {
        $types = array('TYPE_INTERESTED', 'TYPE_PARTICIPANT');
        if (!in_array($type, $types)) {
            throw new \Exception('Invalid type: ' . $type);
        }
    }

    /**
     * Set user as either interested or participant
     * 
     * @param $eventId
     * @param $type
     * @return void
     * @throws \Exception
     */
    public static function setAs($eventId, $type)
    {
        try {
            static::validateType($type);

            $event = EventsModel::where('id', '=', $eventId)->first();
            if (!$event) {
                throw new \Exception('Event not found: ' . $eventId);
            }

            $item = static::where('userId', '=', auth()->id())->where('eventId', '=', $eventId)->first();
            if ($item) {
                if ($item->type !== $type) {
                    $item->type = $type;
                }
            } else {
                $item = new self();
                $item->eventId = $eventId;
                $item->userId = auth()->id();
                $item->type = $type;
            }

            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove from list
     * 
     * @param $eventId
     * @return void
     * @throws \Exception
     */
    public static function remove($eventId)
    {
        try {
            $item = static::where('eventId', '=', $eventId)->where('userId', '=', auth()->id())->first();
            if (!$item) {
                throw new \Exception('Item not found');
            }

            $item->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if user is marked as
     * 
     * @param $eventId
     * @param $userId
     * @param $type
     * @return bool
     * @throws \Exception
     */
    public static function isMarkedAs($eventId, $userId, $type)
    {
        try {
            static::validateType($type);

            $data = static::where('eventId', '=', $eventId)->where('userId', '=', $userId)->where('type', '=', $type)->count();

            return $data === 1;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
