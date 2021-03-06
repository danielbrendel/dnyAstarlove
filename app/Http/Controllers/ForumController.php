<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CaptchaModel;
use App\Models\AppModel;
use App\Models\ForumModel;
use App\Models\ForumThreadModel;
use App\Models\ForumPostModel;
use App\Models\ReportModel;

class ForumController extends Controller
{
    /**
     * Construct object
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            if (!env('APP_ENABLEFORUM')) {
                return redirect('/');
            }

            return $next($request);
        });
    }
    
    /**
     * View forum index
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws Exception
     */
    public function index()
    {
        return view('forum.index', [
            'captchadata' => CaptchaModel::createSum(session()->getId())
        ]);
    }

    /**
     * Get forum list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        try {
            $paginate = request('paginate', null);
            $name = request('name', '');

            $data = ForumModel::queryList($paginate, $name);

            $last = false;
            if (count($data) === 0) {
                $last = true;
            } else {
                $lastId = ForumModel::max('id');
                $last = $lastId === $data[count($data)-1]['id'];
            }

            return response()->json(array('code' => 200, 'data' => $data, 'last' => $last));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * View specific forum
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws Exception
     */
    public function show($id)
    {
        $user = User::getByAuthId();

        $forum = ForumModel::where('id', '=', $id);

        if ((!$user) || ((!$user->admin))) {
            $forum->where('locked', '=', false);
        }

        $forum = $forum->first();

        if (!$forum) {
            return redirect('/forum')->with('flash.error', __('app.forum_not_found_or_locked'));
        }

        $stickies = ForumThreadModel::getStickies($id);

        return view('forum.show', [
            'forum' => $forum,
            'stickies' => $stickies,
            'user' => $user,
            'captchadata' => CaptchaModel::createSum(session()->getId())
        ]);
    }

    /**
     * Get thread list
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function threadList($id)
    {
        try {
            $paginate = request('paginate', null);
            $searchPhrase = request('searchPhrase', null);

            if ($searchPhrase === '') {
                $searchPhrase = null;
            }

            $data = ForumThreadModel::list($id, $paginate, $searchPhrase);

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * View specific forum thread
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws Exception
     */
    public function showThread($id)
    {
        $user = User::getByAuthId();

        $thread = ForumThreadModel::where('id', '=', $id);

        if ((!$user) || (!$user->admin)) {
            $thread->where('locked', '=', false);
        }

        $thread = $thread->first();

        if (!$thread) {
            return redirect('/forum')->with('flash.error', __('app.thread_not_found_or_locked'));
        }

        $thread->owner = User::get($thread->ownerId);

        return view('forum.thread', [
            'user' => $user,
            'thread' => $thread,
            'captchadata' => CaptchaModel::createSum(session()->getId())
        ]);
    }

    /**
     * Get thread postings
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function threadPostings($id)
    {
        try {
            $paginate = request('paginate', null);

            $data = ForumPostModel::getPosts($id, $paginate);

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Create new forum thread
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function createThread()
    {
        try {
            $attr = request()->validate([
                'id' => 'required|numeric',
                'title' => 'required',
                'message' => 'required'
            ]);

            $sticky = false;

            $user = User::getByAuthId();
            if (($user) && ($user->admin)) {
                $sticky = (bool)request('sticky', false);
            }

            $id = ForumThreadModel::add(auth()->id(), $attr['id'], $attr['title'], $attr['message'], $sticky);

            return redirect('/forum/thread/' . $id . '/show')->with('flash.success', __('app.thread_created'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reply to forum thread
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function replyThread()
    {
        try {
            $attr = request()->validate([
                'id' => 'required|numeric',
                'message' => 'required'
            ]);

            $id = ForumPostModel::add($attr['id'], auth()->id(), $attr['message']);

            return back()->with('flash.success', __('app.thread_replied'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Edit forum thread
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function editThread()
    {
        try {
            $attr = request()->validate([
                'id' => 'required|numeric',
                'title' => 'required',
                'sticky' => 'nullable|numeric',
                'locked' => 'nullable|numeric'
            ]);

            if (!isset($attr['sticky'])) {
                $attr['sticky'] = false;
            }

            if (!isset($attr['locked'])) {
                $attr['locked'] = false;
            }

            $user = User::getByAuthId();
            if ((!$user) || (!$user->admin)) {
                throw new Exception(__('app.insufficient_permissions'));
            }

            $id = ForumThreadModel::edit($attr['id'], $attr['title'], (bool)$attr['sticky'], (bool)$attr['locked']);

            return back()->with('flash.success', __('app.thread_edited'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show single forum post
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showPost($id)
    {
        try {
            $user = User::getByAuthId();

            $post = ForumPostModel::where('id', '=', $id);

            if (($user) && (!$user->admin)) {
                $post->where('locked', '=', false);
            }

            $post = $post->first();

            if (!$post) {
                return redirect('/forum')->with('flash.error', __('app.forum_post_not_found_or_locked'));
            }

            $post->user = User::get($post->userId);
            $post->thread = ForumThreadModel::where('id', '=', $post->threadId)->first();

            return view('forum.single', [
                'user' => $user,
                'post' => $post,
                'captchadata' => CaptchaModel::createSum(session()->getId())
            ]);
        } catch (Exception $e) {
            return redirect('/forum')->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Lock a forum post
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function lockPost($id)
    {
        try {
            ForumPostModel::lock($id);

            return response()->json(array('code' => 200, 'msg' => __('app.forum_post_locked_ok')));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Edit forum post
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function editPost()
    {
        try {
            $attr = request()->validate([
                'id' => 'required|numeric',
                'message' => 'required'
            ]);

            $post = ForumPostModel::where('id', '=', $attr['id'])->first();

            $user = User::getByAuthId();
            if (!(($user) && (($post->userId === $user->id) || ((!$user->admin))))) {
                throw new Exception(__('app.insufficient_permissions'));
            }

            ForumPostModel::edit($attr['id'], $attr['message']);

            return back()->with('flash.success', __('app.forum_post_edited'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
