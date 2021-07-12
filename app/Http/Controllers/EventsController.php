<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventsModel;
use App\Models\EventsParticipantsModel;
use App\Models\EventsThreadModel;
use App\Models\User;

/**
 * Class EventsController
 * 
 * Interface to event handling
 */
class EventsController extends Controller
{
    /**
     * Construct object
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show index page
     * 
     * @return mixed
     */
    public function index()
    {
        try {
            $this->validateLogin();

            return view('events.index');
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Query events
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function query()
    {
        try {
            $this->validateLogin();

            $paginate = request('paginate', null);
            $location = request('location', null);

            $data = EventsModel::fetch(env('APP_EVENTSPACKLIMIT', 20), $location, $paginate);
            foreach ($data as &$item) {
                $item->displayDate = date('Y-m-d', strtotime($item->dateOfEvent));
                $item->location = ucfirst($item->location);
                $item->commentCount = EventsThreadModel::where('eventId', '=', $item->id)->count();
                $item->participantCount = EventsParticipantsModel::where('eventId', '=', $item->id)->count();
            }

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Show event
     * 
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $this->validateLogin();

            $user = User::getByAuthId();

            $event = EventsModel::where('id', '=', $id)->first();
            if (!$event) {
                throw new \Exception(__('app.event_not_found'));
            }

            if (!$event->initialApproved) {
                if ((!$user->admin) && ($user->id !== $event->userId)) {
                    throw new \Exception('Insufficient permissions');
                }
            }

            $event->owner = User::get($event->userId);
            $event->participants = EventsParticipantsModel::where('eventId', '=', $id)->where('type', '=', 'TYPE_PARTICIPANT')->get();
            $event->interested = EventsParticipantsModel::where('eventId', '=', $id)->where('type', '=', 'TYPE_INTERESTED')->get();
            $event->self_participating = EventsParticipantsModel::isMarkedAs($id, auth()->id(), 'TYPE_PARTICIPANT');
            $event->self_interested = EventsParticipantsModel::isMarkedAs($id, auth()->id(), 'TYPE_INTERESTED');

            foreach ($event->participants as &$item) {
                $item->user = User::get($item->userId);
            }

            foreach ($event->interested as &$item) {
                $item->user = User::get($item->userId);
            }

            $event->ownerOrAdmin = ($user->admin) || ($event->userId === $user->id);

            return view('events.show', [
                'event' => $event
            ]);
        } catch (\Exception $e) {
            return redirect('/events')->with('error', $e->getMessage());
        }
    }

    /**
     * Create an event
     * 
     * @return mixed
     */
    public function create()
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
                'name' => 'required',
                'content' => 'required',
                'dateOfEvent' => 'required|date',
                'location' => 'required'
            ]);

            $event = EventsModel::add($attr['name'], $attr['content'], $attr['dateOfEvent'], $attr['location']);

            return redirect('/events/show/' . $event)->with('flash.success', __('app.event_created'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Edit event
     * 
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        try {
            $attr = request()->validate([
                'name' => 'required',
                'content' => 'required',
                'dateOfEvent' => 'required|date',
                'location' => 'required'
            ]);

            EventsModel::edit($id, $attr['name'], $attr['content'], $attr['dateOfEvent'], $attr['location']);

            return back()->with('flash.success', __('app.event_edited'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Query thread comments
     * 
     * @param $id
     * @return \Illiminate\Http\JsonResponse
     */
    public function queryComments($id)
    {
        try {
            $this->validateLogin();

            $user = User::getByAuthId();

            $paginate = request('paginate', null);

            $data = EventsThreadModel::fetch($id, env('APP_COMMENTPACKLIMIT', 20), $paginate);
            foreach ($data as &$item) {
                $item->diffForHumans = $item->created_at->diffForHumans();
                $item->updatedDiffForHumans = $item->updated_at->diffForHumans();
                $item->is_sender_or_admin = ($user->admin) || ($user->id === $item->userId);
            }

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Add thread comment
     * 
     * @param $id
     * @return mixed
     */
    public function addComment($id)
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
                'content' => 'required'
            ]);

            EventsThreadModel::add($id, $attr['content']);

            return back()->with('flash.success', __('app.comment_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Edit comment
     * 
     * @return mixed
     */
    public function editComment()
    {
        try {
            $attr = request()->validate([
                'id' => 'required',
                'content' => 'required'
            ]);

            EventsThreadModel::edit($attr['id'], $attr['content']);

            return back()->with('flash.success', __('app.comment_updated'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove a comment
     * 
     * @param $id
     * @return mixed
     */
    public function removeComment($id)
    {
        try {
            EventsThreadModel::remove($id);

            return back()->with('flash.success', __('app.comment_deleted'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Add as participant
     * 
     * @param $id
     * @return mixed
     */
    public function addParticipant($id)
    {
        try {
            $this->validateLogin();

            EventsParticipantsModel::setAs($id, 'TYPE_PARTICIPANT');

            return back()->with('flash.success', __('app.now_participating'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove as participant
     * 
     * @param $id
     * @return mixed
     */
    public function removeParticipant($id)
    {
        try {
            $this->validateLogin();

            EventsParticipantsModel::remove($id);

            return back()->with('flash.success', __('app.now_not_participating_anymore'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Add as interested
     * 
     * @param $id
     * @return mixed
     */
    public function addInterested($id)
    {
        try {
            $this->validateLogin();

            EventsParticipantsModel::setAs($id, 'TYPE_INTERESTED');

            return back()->with('flash.success', __('app.now_interested'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove as interested
     * 
     * @param $id
     * @return mixed
     */
    public function removeInterested($id)
    {
        try {
            $this->validateLogin();

            EventsParticipantsModel::remove($id);

            return back()->with('flash.success', __('app.now_not_interested_anymore'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
