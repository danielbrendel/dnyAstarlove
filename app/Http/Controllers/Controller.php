<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
    }
}
