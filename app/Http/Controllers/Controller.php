<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\CaptchaModel;
use App\Models\AppModel;
use App\Models\User;

/**
 * Class Controller
 *
 * Base controller class
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $captchadata;

    /**
     * @var string
     */
    protected $cookie_consent;

    /**
     * Perform global operations
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!\Auth::guest()) {
                $user = User::where('id', '=', auth()->id())->first();
                $user->last_action = date('Y-m-d H:i:s');
                $user->save();
            }

            return $next($request);
        });

        $this->cookie_consent = AppModel::getCookieConsentText();
    }

    /**
     * Generate captcha
     * 
     * @return array
     */
    protected function generateCaptcha()
    {
        $this->captchadata = CaptchaModel::createSum(session()->getId());

        return $this->captchadata;
    }
}
