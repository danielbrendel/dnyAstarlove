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
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\AppModel;
use App\Models\MessageModel;
use App\Models\IgnoreModel;
use App\Models\LikeModel;

/**
 * Class MessageController
 *
 * Message specific controller
 */
class MessageController extends Controller
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
     * View message list
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        try {
            $this->validateLogin();

            return view('message.list', [
                'user' => User::getByAuthId(),
                'cookie_consent' => AppModel::getCookieConsentText()
            ]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Fetch list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchList()
    {
        try {
            $this->validateLogin();

            $paginate = request('paginate', null);

            $data = MessageModel::fetch(auth()->id(), env('APP_MESSAGEPACKLIMIT', 30), $paginate)->unique('channel')->values()->all();
            foreach ($data as &$item) {
                if ($item->senderId === auth()->id()) {
                    $item->user = User::get($item->userId);
                } else {
                    $item->user = User::get($item->senderId);
                }

                $item->sender = User::get($item->senderId);

                $item->diffForHumans = $item->created_at->diffForHumans();
            }

            return response()->json(array('code' => 200, 'data' => $data, 'min' => MessageModel::where('userId', '=', auth()->id())->orWhere('senderId', '=', auth()->id())->min('id'), 'max' => MessageModel::where('userId', '=', auth()->id())->orWhere('senderId', '=', auth()->id())->max('id'), 'count' =>  count($data)));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Show message thread
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $this->validateLogin();

            $msg = MessageModel::getMessageThread($id);
            if (!$msg) {
                return back()->with('error', __('app.message_not_found'));
            }

            $msg->user = User::get($msg->userId);
            $msg->sender = User::get($msg->senderId);

            if ($msg->senderId == auth()->id()) {
                $msg->message_partner = $msg->user->name;
            } else {
                $msg->message_partner = $msg->sender->name;
            }

            return view('message.show', [
                'user' => User::getByAuthId(),
                'msg' => $msg
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Query message pack
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function query()
    {
        try {
            $ident = request('id');
            $paginate = request('paginate');

            $data = MessageModel::queryThreadPack($ident, env('APP_MESSAGETHREADPACK', 30), $paginate);

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * View message creation form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function create()
    {
        try {
            $this->validateLogin();

            $username = request('u', '');
            if ((is_string($username)) && (strlen($username > 0))) {
                $user = User::getByName($username);
                if ($user) {
                    $chat = MessageModel::getChatWithUser(auth()->id(), $user->id);

                    return redirect('/messages/show/' . $chat->id);
                }
            }

            return view('message.create', [
                'user' => User::getByAuthId(),
                'username' => request('u', ''),
                'cookie_consent' => AppModel::getCookieConsentText()
            ]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Send message
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Throwable
     */
    public function send()
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
               'username' => 'required',
               'subject' => 'required',
               'text' => 'required'
            ]);

            if (!isset($attr['subject'])) {
                $attr['subject'] = '';
            }

            $sender = User::getByAuthId();
            if (!$sender) {
                throw new \Exception('Not logged in');
            }

            $receiver = User::getByName($attr['username']);
            if (!$receiver) {
                throw new \Exception(__('app.user_not_found'));
            }

            if (IgnoreModel::hasIgnored($receiver->id, $sender->id)) {
                throw new \Exception(__('app.user_not_receiving_messages'));
            }

            if (!LikeModel::bothLiked($receiver->id, $sender->id)) {
                throw new \Exception(__('app.both_not_liked'));
            }
            
            $id = MessageModel::add($receiver->id, $sender->id, $attr['subject'], $attr['text']);
            
            return redirect('/messages/show/' . $id)->with('flash.success', __('app.message_sent'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get amount of unread messages
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unreadCount()
    {
        try {
            $this->validateLogin();

            $count = MessageModel::unreadCount(auth()->id());

            return response()->json(array('code' => 200, 'count' => $count));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }
}
