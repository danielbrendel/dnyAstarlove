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
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\EventsParticipantsModel;
use App\Models\EventsThreadModel;

/**
 * Class EventsModel
 * 
 * Represents interface to events
 */
class EventsModel extends Model
{
    use HasFactory;

    /**
     * Add a new event
     * 
     * @param $name
     * @param $content
     * @param $dateOfEvent
     * @param $location
     * @return int
     * @throws \Exception
     */
    public static function add($name, $content, $dateOfEvent, $location)
    {
        try {
            $item = new self();
            $item->userId = auth()->id();
            $item->name = $name;
            $item->content = \Purifier::clean($content);
            $item->dateOfEvent = $dateOfEvent;
            $item->location = strtolower($location);
            $item->approved = false;
            $item->initialApproved = false;
            $item->save();

            return $item->id;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Edit an event
     * 
     * @param $eventId
     * @param $name
     * @param $content
     * @param $dateOfEvent
     * @param $location
     * @return void
     * @throws \Exception
     */
    public static function edit($eventId, $name, $content, $dateOfEvent, $location)
    {
        try {
            $event = static::where('id', '=', $eventId)->first();
            if (!$event) {
                throw new \Exception('Event not found: ' . $eventId);
            }

            $user = User::getByAuthId();

            if ((!$user->admin) || ($user->id !== $event->userId)) {
                throw new \Exception('Insufficient permissions');
            }

            $event->name = $name;
            $event->content = \Purifier::clean($content);
            $event->dateOfEvent = $dateOfEvent;
            $event->location = strtolower($location);
            $event->approved = false;
            $event->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove an event
     * 
     * @param $eventId
     * @return void
     * @throws \Exception
     */
    public static function remove($eventId)
    {
        try {
            $event = static::where('id', '=', $eventId)->first();
            if (!$event) {
                throw new \Exception('Event not found: ' . $eventId);
            }

            $user = User::getByAuthId();

            if ((!$user->admin) || ($user->id !== $event->userId)) {
                throw new \Exception('Insufficient permissions');
            }

            $participants = EventsParticipantsModel::where('eventId', '=', $eventId)->get();
            foreach ($participants as $item) {
                $item->delete();
            }

            $messages = EventsThreadModel::where('eventId', '=', $eventId)->get();
            foreach ($messages as $item) {
                $item->delete();
            }

            $event->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Fetch event pack
     * 
     * @param $limit
     * @param $location
     * @param $paginate
     * @return mixed
     * @throws \Exception
     */
    public static function fetch($limit, $location = null, $paginate = null)
    {
        try {
            $query = static::where('initialApproved', '=', true)->where('dateOfEvent', '>=', Carbon::now());

            if (($location !== null) && (is_string($location))) {
                $query->where('location', '=', strtolower($location));
            }

            if ($paginate !== null) {
                $query->where('dateOfEvent', '>', $paginate);
            }

            return $query->orderBy('dateOfEvent', 'asc')->limit($limit)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get current event count
     * 
     * @return int
     * @throws \Exception
     */
    public static function getCurrentEventCount()
    {
        try {
            $count = static::where('dateOfEvent', '>=', Carbon::now())->where('initialApproved', '=', true)->count();

            return $count;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
