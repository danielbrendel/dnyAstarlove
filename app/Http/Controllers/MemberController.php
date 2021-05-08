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
use App\Models\LikeModel;
use App\Models\IgnoreModel;
use App\Models\VisitorModel;
use App\Models\VerifyModel;
use App\Models\FavoritesModel;
use App\Models\PhotoApprovalModel;

/**
 * Class MemberController
 *
 * Member specific controller
 */
class MemberController extends Controller
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
     * Show profiles page
     * 
     * @return \Illuminate\View\View
     */
    public function profiles()
    {
        try {
            $this->validateLogin();

            $user = User::getByAuthId();

            /*if ((is_null($user->latitude)) || (is_null($user->longitude))) {
                return redirect('/')->with('error', __('app.geo_required'));
            }*/

            return view('member.profiles');
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Show random profile
     * 
     * @return mixed
     */
    public function random()
    {
        try {
            $this->validateLogin();

            $user = User::where('deactivated', '=', false)->where('account_confirm', '=', '_confirmed')->where('id', '<>', auth()->id())->inRandomOrder()->first();

            $user->ignored = IgnoreModel::hasIgnored(auth()->id(), $user->id);
            $user->age = Carbon::parse($user->birthday)->age;

            switch ($user->gender) {
                case User::GENDER_MALE:
                    $user->gender = __('app.gender_male');
                    break;
                case User::GENDER_FEMALE:
                    $user->gender = __('app.gender_female');
                    break;
                case User::GENDER_DIVERSE:
                    $user->gender = __('app.gender_diverse');
                    break;
                default:
                    $user->gender = __('app.gender_unspecified');
                    break;
            }

            $user->is_online = User::isMemberOnline($user->id);
            $user->last_seen = Carbon::parse($user->last_action)->diffForHumans();
            $user->is_self = $user->id === auth()->id();
            $user->self_liked = LikeModel::hasLiked(auth()->id(), $user->id);
            $user->liked_back = LikeModeL::hasLiked($user->id, auth()->id());
            $user->both_liked = ($user->self_liked) && ($user->liked_back);
            $user->favorited = FavoritesModel::hasFavorited(auth()->id(), $user->id);

            User::filterNonApprovedPhotos($user);

            return view('member.random', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Check for username availability and identifier validity
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function nameValidity()
    {
        try {
            $username = request('ident', '');

            $data = array(
                'username' => $username,
                'available' => User::getByName($username) == null,
                'valid' => User::isValidNameIdent($username)
            );

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Query user profiles
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryProfiles()
    {
        try {
            $this->validateLogin();

            $geo = (int)request('georange', env('APP_GEORANGE', 1000));
            $male = request('male', 1);
            $female = request('female', 1);
            $diverse = request('diverse', 1);
            $orientation = request('orientation', 1);
            $from = request('from', 18);
            $till = request('till', 100);
            $online = request('online', false);
            $paginate = request('paginate', null);

            $data = User::queryProfiles($geo, $male, $female, $diverse, $orientation, $from, $till, $online, $paginate);
            foreach ($data as &$item) {
                User::filterNonApprovedPhotos($item);
            }

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Store member geo position
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function saveGeoLocation()
    {
        try {
            $this->validateLogin();

            $latitude = request('latitude', null);
            $longitude = request('longitude', null);

            User::storeGeoLocation($latitude, $longitude);

            return response()->json(array('code' => 200));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Show user profile
     * 
     * @param $ident
     * @return mixed
     */
    public function showUser($ident)
    {
        try {
            $this->validateLogin();

            $user = User::getByName($ident);
            if (!$user) {
                $user = User::get((int)$ident);
            }

            if ((!$user) || ($user->deactivated) || (IgnoreModel::hasIgnored($user->id, auth()->id()))) {
                throw new \Exception(__('app.user_not_found_or_deactivated'));
            }

            if ($user->id !== auth()->id()) {
                VisitorModel::add(auth()->id(), $user->id);
            }

            $user->ignored = IgnoreModel::hasIgnored(auth()->id(), $user->id);
            $user->age = Carbon::parse($user->birthday)->age;
            $user->verified = VerifyModel::getState($user->id) == VerifyModel::STATE_VERIFIED;

            switch ($user->gender) {
                case User::GENDER_MALE:
                    $user->gender = __('app.gender_male');
                    break;
                case User::GENDER_FEMALE:
                    $user->gender = __('app.gender_female');
                    break;
                case User::GENDER_DIVERSE:
                    $user->gender = __('app.gender_diverse');
                    break;
                default:
                    $user->gender = __('app.gender_unspecified');
                    break;
            }

            $user->is_online = User::isMemberOnline($user->id);
            $user->last_seen = Carbon::parse($user->last_action)->diffForHumans();
            $user->is_self = $user->id === auth()->id();
            $user->self_liked = LikeModel::hasLiked(auth()->id(), $user->id);
            $user->liked_back = LikeModeL::hasLiked($user->id, auth()->id());
            $user->both_liked = ($user->self_liked) && ($user->liked_back);
            $user->favorited = FavoritesModel::hasFavorited(auth()->id(), $user->id);

            if ($user->id !== auth()->id()) {
                $viewer = User::getByAuthId();
                
                if (!$viewer->admin) {
                    User::filterNonApprovedPhotos($user);
                }
            }

            return view('member.profile', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Like a user
     * 
     * @param $id
     * @return mixed
     */
    public function likeUser($id)
    {
        try {
            $this->validateLogin();

            $user = User::get($id);
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception(__('app.user_not_found_or_deactivated'));
            }

            LikeModel::add(auth()->id(), $id);

            return redirect('/user/' . $user->name)->with('flash.success', __('app.liked_successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Unlike a user
     * 
     * @param $id
     * @return mixed
     */
    public function unlikeUser($id)
    {
        try {
            $this->validateLogin();

            LikeModel::remove(auth()->id(), $id);

            return back()->with('flash.success', __('app.unliked_successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Ignore a user
     * 
     * @param $id
     * @return mixed
     */
    public function ignoreUser($id)
    {
        try {
            $this->validateLogin();

            IgnoreModel::add(auth()->id(), $id);

            return back()->with('flash.success', __('app.ignored_successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Un-ignore a user
     * 
     * @param $id
     * @return mixed
     */
    public function unignoreUser($id)
    {
        try {
            $this->validateLogin();

            IgnoreModel::remove(auth()->id(), $id);

            return back()->with('flash.success', __('app.unignored_successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Report a user
     * 
     * @param $id
     * @return mixed
     */
    public function reportUser($id)
    {
        try {
            $this->validateLogin();

            //ReportModel::add(auth()->id(), $id);

            return back()->with('flash.success', __('app.reported_successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * View settings page
     * 
     * @return mixed
     */
    public function viewSettings()
    {
        try {
            $this->validateLogin();

            $user = User::getByAuthId();
            $user->state = VerifyModel::getState($user->id);
            $user->birthday = Carbon::parse($user->birthday)->format('Y-m-d');

            return view('member.settings', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Query visitors
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryVisitors()
    {
        try {
            $this->validateLogin();

            $paginate = request('paginate', null);

            $data = VisitorModel::getVisitorPack(auth()->id(), env('APP_VISITORPACK', 20), $paginate);
            foreach ($data as &$item) {
                $item['user'] = User::get($item['visitorId'])->toArray();
            }

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Query received like list
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryReceivedLikes()
    {
        try {
            $this->validateLogin();

            $paginate = request('paginate', null);

            $data = LikeModel::queryReceivedLikes(auth()->id(), env('APP_LIKEPACK', 20), $paginate);
            foreach ($data as &$item) {
                $item['user'] = User::get($item['userId'])->toArray();
            }

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Query given like list
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryGivenLikes()
    {
        try {
            $this->validateLogin();

            $paginate = request('paginate', null);

            $data = LikeModel::queryGivenLikes(auth()->id(), env('APP_LIKEPACK', 20), $paginate);
            foreach ($data as &$item) {
                $item['user'] = User::get($item['likedUserId'])->toArray();
            }

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Query ignore list
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryIgnoreList()
    {
        try {
            $this->validateLogin();

            $paginate = request('paginate', null);

            $data = IgnoreModel::getIgnorePack(auth()->id(), env('APP_IGNOREPACK', 10), $paginate);
            foreach ($data as &$item) {
                $item['user'] = User::get($item['targetId'])->toArray();
            }

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Save profile data
     * 
     * @return mixed
     */
    public function saveProfile()
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
                'username' => 'required',
                'realname' => 'nullable',
                'birthday' => 'nullable|date',
                'gender' => 'nullable|numeric',
                'orientation' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'rel_status' => 'nullable',
                'location' => 'nullable',
                'job' => 'nullable',
                'introduction' => 'nullable',
                'interests' => 'nullable',
                'music' => 'nullable',
                'language' => 'nullable'
            ]);

            if (!isset($attr['realname'])) {
                $attr['realname'] = null;
            }

            if (!isset($attr['birthday'])) {
                $attr['birthday'] = null;
            }

            if (!isset($attr['gender'])) {
                $attr['gender'] = null;
            }

            if (!isset($attr['orientation'])) {
                $attr['orientation'] = 1;
            }

            if (!isset($attr['height'])) {
                $attr['height'] = null;
            }

            if (!isset($attr['weight'])) {
                $attr['weight'] = null;
            }

            if (!isset($attr['rel_status'])) {
                $attr['rel_status'] = null;
            }

            if (!isset($attr['location'])) {
                $attr['location'] = null;
            }

            if (!isset($attr['job'])) {
                $attr['job'] = null;
            }

            if (!isset($attr['introduction'])) {
                $attr['introduction'] = null;
            }

            if (!isset($attr['interests'])) {
                $attr['interests'] = null;
            }

            if (!isset($attr['music'])) {
                $attr['music'] = null;
            }

            if (!isset($attr['language'])) {
                $attr['language'] = env('APP_LANG', 'en');
            }

            User::saveProfile($attr);

            return redirect('/settings?tab=profile')->with('flash.success', __('app.profile_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save user password
     * 
     * @return mixed
     */
    public function savePassword()
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
                'password' => 'required',
                'password_confirmation' => 'required'
            ]);

            User::savePassword($attr['password'], $attr['password_confirmation']);

            return redirect('/settings?tab=security')->with('flash.success', __('app.password_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save user e-mail
     * 
     * @return mixed
     */
    public function saveEmail()
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
                'email' => 'required|email'
            ]);

            User::saveEmail($attr['email']);

            return redirect('/settings?tab=security')->with('flash.success', __('app.email_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save geo exclude flag
     * 
     * @return mixed
     */
    public function saveGeoExclude()
    {
        try {
            $this->validateAdmin();

            $attr = request()->validate([
                'geoexclude' => 'numeric|nullable'
            ]);

            if (!isset($attr['geoexclude'])) {
                $attr['geoexclude'] = false;
            }

            User::saveGeoExclude($attr['geoexclude']);

            return redirect('/settings?tab=security')->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save photo
     * 
     * @return mixed
     */
    public function savePhoto()
    {
        try {
            $attr = request()->validate([
                'image' => 'file',
                'which' => 'required'
            ]);

            User::savePhoto($attr['which']);

            return redirect('/settings?tab=photos')->with('flash.success', __('app.photo_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete photo
     * 
     * @param $which
     * @return mixed
     */
    public function deletePhoto($which)
    {
        try {
            User::deletePhoto($which);

            return redirect('/settings?tab=photos')->with('flash.success', __('app.photo_deleted'));
        } catch (\Exception $e) {
            return redirect('/settings?tab=photos')->with('error', $e->getMessage());
        }
    }

    /**
     * Save notification settings
     * 
     * @return mixed
     */
    public function saveNotifications()
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
                'mail_on_message' => 'nullable|numeric',
                'newsletter' => 'nullable|numeric'
            ]);

            if (!isset($attr['mail_on_message'])) {
                $attr['mail_on_message'] = false;
            }

            if (!isset($attr['newsletter'])) {
                $attr['newsletter'] = false;
            }

            User::saveNotifications($attr);

            return redirect('/settings?tab=notifications')->with('flash.success', __('app.notifications_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Add user to favorites
     * 
     * @param $id
     * @return mixed
     */
    public function addFavorite($id)
    {
        try {
            $this->validateLogin();

            $user = User::get($id);
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception(__('app.user_not_found_or_deactivated'));
            }

            FavoritesModel::add(auth()->id(), $id);

            return back()->with('flash.success', __('app.added_to_favorites'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove user from favorites
     * 
     * @param $id
     * @return mixed
     */
    public function removeFavorite($id)
    {
        try {
            $this->validateLogin();

            FavoritesModel::remove(auth()->id(), $id);

            return back()->with('flash.success', __('app.removed_from_favorites'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Query favorites
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryFavorites()
    {
        try {
            $this->validateLogin();

            $paginate = request('paginate', null);

            $data = FavoritesModel::fetch(auth()->id(), env('APP_FAVORITEPACKCOUNT', 30), $paginate)->toArray();
            foreach ($data as &$item) {
                $item['user'] = User::get($item['favoriteId'])->toArray();
                $item['user']['is_online'] = User::isMemberOnline($item['user']['id']);
                $item['user']['last_seen'] = Carbon::parse($item['user']['last_action'])->diffForHumans();
            }

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Apply for account verification
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyAccount()
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
                'idcard_front' => 'required|file',
                'idcard_back' => 'required|file',
                'confirmation' => 'required|numeric'
            ]);

            VerifyModel::addVerifyAccount(auth()->id(), $attr);

            return redirect('/settings?tab=membership')->with('success', __('app.verify_account_ok'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete user account of authenticated user
     * 
     * @return mixed
     */
    public function deleteAccount()
    {
        try {
            $this->validateLogin();

            $attr = request()->validate([
                'keyphrase' => 'required'
            ]);

            if ($attr['keyphrase'] !== env('APP_KEYPHRASE')) {
                throw new \Exception(__('app.invalid_keyphrase'));
            }

            User::deleteAccount(auth()->id());

            \Auth::logout();

            return redirect('/')->with('success', __('app.account_deleted'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
