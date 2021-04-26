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
        return view('member.profiles');
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
            $latitude = request('latitude', null);
            $longitude = request('longitude', null);

            User::storeGeoLocation($latitude, $longitude);

            return response()->json(array('code' => 200));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }
}
