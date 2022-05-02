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
use App\Models\User;

/**
 * Class PaymentController
 * 
 * Payment processings
 */
class PaymentController extends Controller
{
    /**
     * PaymentController constructor.
     *
     * @return void
     */
    public function __construct()
    {
		parent::__construct();
		
        $this->middleware(function ($request, $next) {
            if (\Auth::guest()) {
                abort(403);
            }

            return $next($request);
        });

        \Stripe\Stripe::setApiKey(env('STRIPE_TOKEN_SECRET'));
    }

    /**
     * Perform the payment operation
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function charge()
    {
        try {
			if (!env('STRIPE_ENABLE')) {
				throw new \Exception(__('app.payment_service_deactivated'));
			}
			
            $attr = request()->validate([
               'stripeToken' => 'required'
            ]);

            $user = User::get(auth()->id());
            if ((!$user) || ($user->deactivated) || (!User::promodeExpired($user))) {
                throw new \Exception(__('app.user_not_found_or_locked_or_already_pro'));
            }

            $charge = \Stripe\Charge::create([
                'amount' => env('STRIPE_COSTS_VALUE'),
                'currency' => env('STRIPE_CURRENCY'),
                'description' => 'Purchasing of pro mode for ' . $user->name . '/' . $user->id . ' (' . $user->email . ')',
                'source' => $attr['stripeToken'],
                'receipt_email' => $user->email
            ]);

            if ((!$charge instanceof \Stripe\Charge) || (!isset($charge->status) || ($charge->status !== 'succeeded'))) {
                throw new \Exception(__('app.payment_failed'));
            }

            $user->last_payed = date('Y-m-d H:i:s', time());
            $user->save();

            return redirect('/settings?tab=membership')->with('success', __('app.payment_succeeded'));
        } catch (\Exception $e) {
            return redirect('/settings?tab=membership')->with('error', $e->getMessage());
        }
    }
}
