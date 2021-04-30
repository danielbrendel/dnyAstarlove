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
use App\Models\AppModel;
use App\Models\FeatureItemModel;
use App\Models\FaqModel;
use App\Models\User;
use App\Models\CaptchaModel;
use App\Models\MessageModel;
use App\Models\VerifyModel;
use App\Models\VisitorModel;

/**
 * Class MainController
 *
 * Main controller operations
 */
class MainController extends Controller
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
     * Show index page according to auth status
     * 
     * @return mixed
     */
    public function index()
    {
        if (\Auth::guest()) {
            return view('guest.home', [
                'settings' => AppModel::getAppSettings(),
                'features' => FeatureItemModel::getAll(),
                'captchadata' => $this->generateCaptcha()
            ]);
        } else {
            $user = User::getByAuthId();

            $user->verify_state = VerifyModel::getState($user->id);
            $user->visitor_count = VisitorModel::getUnseenCount($user->id);
            $user->message_count = MessageModel::unreadCount($user->id);
            $user->promode_count = env('STRIPE_EXPIRE_DAY_COUNT') - (Carbon::parse($user->last_payed)->diffInDays(Carbon::now()));

            return view('member.home', [
                'user' => $user
            ]);
        }
    }

    /**
     * Show client endpoint index page
     * 
     * @return mixed
     */
    public function clepIndex()
    {
        if ((\Auth::guest()) || (!isset($_COOKIE['clep']))) {
            return view('guest.clep', [
                'captchadata' => $this->generateCaptcha()
            ]);
        } else {
            session()->reflash();

            return redirect('/' . ((isset($_GET['clep_push_handler'])) ? '?clep_push_handler=' . $_GET['clep_push_handler'] : ''));
        }
    }

    /**
     * View faq page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq()
    {
        return view('home.faq', ['captchadata' => $this->generateCaptcha(), 'faqs' => FaqModel::getAll()]);
    }

    /**
     * View imprint page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function imprint()
    {
        return view('home.imprint', ['captchadata' => $this->generateCaptcha(), 'imprint_content' => AppModel::getImprint()]);
    }

    /**
     * View news page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function news()
    {
        return view('home.news', ['captchadata' => $this->generateCaptcha()]);
    }

    /**
     * View tos page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tos()
    {
        return view('home.tos', ['captchadata' => $this->generateCaptcha(), 'tos_content' => AppModel::getTermsOfService()]);
    }

    /**
     * View contact page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewContact()
    {
        return view('home.contact', ['captchadata' => $this->generateCaptcha()]);
    }

    /**
     * Perform registration
     * 
     * @return mixed
     */
    public function register()
    {
        try {
            $attr = request()->validate([
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'password_confirmation' => 'required',
                'captcha' => 'required'
            ]);

            $id = User::register($attr);

            return back()->with('success', __('app.register_confirm_email', ['id' => $id]));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * View password reset form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewReset()
    {
        return view('home.pwreset', [
            'hash' => request('hash', ''),
            'captchadata' => $this->generateCaptcha()
        ]);
    }

    /**
     * Send email with password recovery link to user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Throwable
     */
    public function recover()
    {
        $attr = request()->validate([
            'email' => 'required|email'
        ]);

        try {
            User::recover($attr['email']);

            return back()->with('success', __('app.pw_recovery_ok'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reset password
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reset()
    {
        $attr = request()->validate([
            'password' => 'required',
            'password_confirm' => 'required'
        ]);

        $hash = request('hash');

        try {
            User::reset($attr['password'], $attr['password_confirm'], $hash);

            return redirect('/')->with('success', __('app.password_reset_ok'));
        } catch (Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Resend confirmation link
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws Throwable
     */
    public function resend($id)
    {
        try {
            User::resend($id);

            return back()->with('success', __('app.resend_ok', ['id' => $id]));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Confirm account
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirm()
    {
        $hash = request('hash');

        try {
            User::confirm($hash);

            return redirect('/')->with('success', __('app.register_confirmed_ok'));
        } catch (Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    /**
     * Perform login
     * 
     * @return mixed
     */
    public function login()
    {
        try {
            $attr = request()->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (\Auth::guest()) {
                $user = User::getByEmail($attr['email']);
                if ($user !== null) {
                    if ($user->account_confirm !== '_confirmed') {
                        return back()->with('error', __('app.account_not_yet_confirmed'));
                    }
    
                    if ($user->deactivated) {
                        return back()->with('error', __('app.account_deactivated'));
                    }
                }
    
                if (\Auth::attempt([
                    'email' => $attr['email'],
                    'password' => $attr['password']
                ])) {
                    return redirect('/')->with('flash.success', __('app.login_successful'));
                } else {
                    return back()->with('error', __('app.login_failed'));
                }
            } else {
                return back()->with('error', __('app.login_already_logged_in'));
            }

            return redirect('/')->with('flash.success', __('login_successful'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Perform logout
     * 
     * @return mixed
     */
    public function logout()
    {
        try {
            \Auth::logout();

            return redirect('/')->with('flash.success', __('app.logout_successful'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Process contact request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contact()
    {
        try {
            $attr = request()->validate([
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'body' => 'required',
                'captcha' => 'required'
            ]);

            if ($attr['captcha'] !== CaptchaModel::querySum(session()->getId())) {
                return back()->with('error', __('app.captcha_invalid'))->withInput();
            }

            AppModel::createTicket($attr['name'], $attr['email'], $attr['subject'], $attr['body']);

            return back()->with('success', __('app.contact_success'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Return ad code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function adCode()
    {
        try {
            $adcode = AppModel::getAdCode();

            return response()->json(array('code' => 200, 'adcode' => $adcode));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Perform newsletter cronjob
     *
     * @param $password
     * @return \Illuminate\Http\JsonResponse
     */
    public function cronjob_newsletter($password)
    {
        try {
            if ($password !== env('APP_CRONPW')) {
                return response()->json(array('code' => 403));
            }

            $data = AppModel::newsletterJob();

            return response()->json(array('code' => 200, 'data' => $data));
        } catch (Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }
}
