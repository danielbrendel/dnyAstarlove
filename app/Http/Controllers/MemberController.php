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
}
