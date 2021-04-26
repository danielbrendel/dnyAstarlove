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

            return view('member.profiles');
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
            $from = request('from', 18);
            $till = request('till', 100);
            $online = request('online', false);
            $paginate = request('paginate', null);

            $data = User::queryProfiles($geo, $male, $female, $diverse, $from, $till, $online, $paginate);

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
     * @return mixed
     */
    public function showUser($name)
    {
        try {
            $user = User::getByName($name);

            if ((!$user) || ($user->deactivated)) {
                throw new \Exception(__('app.user_not_found_or_deactivated'));
            }

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

            return view('member.profile', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }
}
