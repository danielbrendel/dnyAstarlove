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
use App\Models\AppModel;
use App\Models\FaqModel;
use App\Models\FeatureItemModel;
use App\Models\ReportModel;
use App\Models\VerifyModel;
use App\Models\MailerModel;
use App\Models\PhotoApprovalModel;
use App\Models\EventsModel;
use App\Models\EventsParticipantsModel;
use App\Models\EventsThreadModel;
use App\Models\AnnouncementsModel;

/**
 * Class AdminController
 * 
 * Admin operations
 */
class AdminController extends Controller
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
            try {
                $this->validateAdmin();
            } catch (\Exception $e) {
                abort(403);
            }

            return $next($request);
        });
    }

    /**
     * Show index page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $langs = AppModel::getLanguageList();

        $reports = ReportModel::getReportPack()->toArray();
        foreach ($reports as &$report) {
            $report['user'] = User::get($report['targetId'])->toArray();
        }

        $approvals = PhotoApprovalModel::fetchPack(env('APP_PHOTOAPPROVALPACKLIMIT', 20));

        $events = EventsModel::where('initialApproved', '=', false)->orWhere('approved', '=', false)->limit(env('APP_EVENTSPACKLIMIT', 20))->get();
        foreach ($events as &$event) {
            $event->user = User::get($event->userId);
        }

        return view('admin.index', [
            'settings' => AppModel::getAppSettings(),
            'themes' => AppModel::getThemeList(),
            'langs' => $langs,
            'features' => FeatureItemModel::getAll(),
            'faqs' => FaqModel::getAll(),
            'reports' => ReportModel::getReportPack(),
            'verification_users' => VerifyModel::fetchPack(),
            'approvals' => $approvals,
            'events' => $events
        ]);
    }

    /**
     * Save about data
     * 
     * @return mixed
     */
    public function saveAbout()
    {
        try {
            $attr = request()->validate([
                'headline' => 'required',
                'subline' => 'required',
                'description' => 'required'
            ]);

            AppModel::saveAbout($attr);

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save cookie consent
     * 
     * @return mixed
     */
    public function saveCookieConsent()
    {
        try {
            $attr = request()->validate([
                'cookieconsent' => 'required'
            ]);

            AppModel::saveSetting('cookie_consent', $attr['cookieconsent']);

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save registration info
     * 
     * @return mixed
     */
    public function saveRegInfo()
    {
        try {
            $attr = request()->validate([
                'reginfo' => 'required'
            ]);

            AppModel::saveSetting('reg_info', $attr['reginfo']);

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save ToS content
     * 
     * @return mixed
     */
    public function saveTosContent()
    {
        try {
            $attr = request()->validate([
                'tos' => 'required'
            ]);

            AppModel::saveSetting('tos', $attr['tos']);

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save imprint content
     * 
     * @return mixed
     */
    public function saveImprintContent()
    {
        try {
            $attr = request()->validate([
                'imprint' => 'required'
            ]);

            AppModel::saveSetting('imprint', $attr['imprint']);

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save head code content
     * 
     * @return mixed
     */
    public function saveHeadCode()
    {
        try {
            $attr = request()->validate([
                'headcode' => 'required'
            ]);

            AppModel::saveSetting('head_code', $attr['headcode']);

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save ad code content
     * 
     * @return mixed
     */
    public function saveAdCode()
    {
        try {
            $attr = request()->validate([
                'adcode' => 'required'
            ]);

            AppModel::saveSetting('ad_code', $attr['adcode']);

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Create feature item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createFeature()
    {
        try {
            $attr = request()->validate([
                'title' => 'required',
                'description' => 'required'
            ]);

            FeatureItemModel::add($attr['title'], $attr['description']);

            return back()->with('flash.success', __('app.feature_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Edit feature item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editFeature()
    {
        try {
            $attr = request()->validate([
                'id' => 'required|numeric',
                'title' => 'required',
                'description' => 'required'
            ]);

            FeatureItemModel::edit($attr['id'], $attr['title'], $attr['description']);

            return back()->with('flash.success', __('app.feature_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove feature item
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFeature($id)
    {
        try {
            $feature = FeatureItemModel::where('id', '=', $id)->first();
            $feature->delete();

            return back()->with('flash.success', __('app.feature_removed'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Create FAQ item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createFaq()
    {
        try {
            $attr = request()->validate([
                'question' => 'required',
                'answer' => 'required'
            ]);

            $faq = new FaqModel();
            $faq->question = $attr['question'];
            $faq->answer = $attr['answer'];
            $faq->save();

            return back()->with('flash.success', __('app.faq_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Edit FAQ item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editFaq()
    {
        try {
            $attr = request()->validate([
                'id' => 'required|numeric',
                'question' => 'required',
                'answer' => 'required'
            ]);

            $faq = FaqModel::where('id', '=', $attr['id'])->first();
            $faq->question = $attr['question'];
            $faq->answer = $attr['answer'];
            $faq->save();

            return back()->with('flash.success', __('app.faq_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove FAQ item
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFaq($id)
    {
        try {
            $faq = FaqModel::where('id', '=', $id)->first();
            $faq->delete();

            return back()->with('flash.success', __('app.faq_removed'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store env configuration
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function envSave()
    {
        try {
            foreach ($_POST as $key => $value) {
                if (substr($key, 0, 4) === 'ENV_') {
                    $_ENV[substr($key, 4)] = $value;
                }
            }

            AppModel::saveEnvironmentConfig();

            return back()->with('flash.success', __('app.env_saved'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Get user details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userDetails()
    {
        try {
            $ident = request('ident');

            $user = User::get($ident);
            if (!$user) {
                $user = User::getByName($ident);
                if (!$user) {
                    $user = User::getByEmail($ident);
                    if (!$user) {
                        return response()->json(array('code' => 404, 'msg' => __('app.user_not_found')));
                    }
                }
            }

            return response()->json(array('code' => 200, 'data' => $user));
        } catch (\Exception $e) {
            return response()->json(array('code' => 500, 'msg' => $e->getMessage()));
        }
    }

    /**
     * Save user data
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userSave()
    {
        try {
            $attr = request()->validate([
                'id' => 'required|numeric',
                'username' => 'required',
                'email' => 'required|email',
                'deactivated' => 'nullable|numeric',
                'admin' => 'nullable|numeric'
            ]);

            $user = User::get($attr['id']);
            if (!$user) {
                return back()->with('flash.error', __('app.user_not_found'));
            }

            $user->name = $attr['username'];
            $user->email = $attr['email'];
            $user->deactivated = (isset($attr['deactivated'])) ? (bool)$attr['deactivated'] : false;
            $user->admin = (isset($attr['admin'])) ? (bool)$attr['admin'] : false;
            $user->save();

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reset user password
     * 
     * @param $id
     * @return mixed
     */
    public function userResetPassword($id)
    {
        try {
            $user = User::get($id);

            User::recover($user->email);

            return back()->with('flash.success', __('app.pw_recovery_ok'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete user account
     * 
     * @param $id
     * @return mixed
     */
    public function userDelete($id)
    {
        try {
            User::deleteAccount($id);

            return back()->with('flash.success', __('app.account_deleted'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Send newsletter
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newsletter()
    {
        try {
            $attr = request()->validate([
               'subject' => 'required',
               'content' => 'required'
            ]);

            AppModel::initNewsletter($attr['subject'], $attr['content']);

            return back()->with('flash.success', __('app.newsletter_in_progress'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save logo
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveLogo()
    {
        try {
            $attr = request()->validate([
               'logo' => 'required|file'
            ]);

            $av = request()->file('logo');
            if ($av != null) {
                if ($av->getClientOriginalExtension() !== 'png') {
                    return back()->with('error', __('app.not_a_png_file'));
                }

                $tmpName = md5(random_bytes(55));

                $av->move(public_path() . '/', $tmpName . '.' . $av->getClientOriginalExtension());

                list($width, $height) = getimagesize(base_path() . '/public/' . $tmpName . '.' . $av->getClientOriginalExtension());

                $avimg = imagecreatetruecolor(128, 128);
                if (!$avimg)
                    throw new \Exception('imagecreatetruecolor() failed');

                $srcimage = null;
                $newname =  'logo.' . $av->getClientOriginalExtension();
                switch (AppModel::getImageType(public_path() . '/' . $tmpName . '.' . $av->getClientOriginalExtension())) {
                    case IMAGETYPE_PNG:
                        $srcimage = imagecreatefrompng(public_path() . '/' . $tmpName . '.' . $av->getClientOriginalExtension());
                        imagecopyresampled($avimg, $srcimage, 0, 0, 0, 0, 128, 128, $width, $height);
                        imagepng($avimg, public_path() . '/' . $newname);
                        break;
                    default:
                        return back()->with('error', __('app.not_a_png_file'));
                        break;
                }

                unlink(public_path() . '/' . $tmpName . '.' . $av->getClientOriginalExtension());

                return back()->with('flash.success', __('app.data_saved'));
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save background
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveBackground()
    {
        try {
            $attr = request()->validate([
                'bg_alpha' => 'required|numeric'
            ]);

            AppModel::saveSetting('alphaChannel', $attr['bg_alpha']);

            $ba = request()->file('background');
            if ($ba != null) {
                $newName = md5(random_bytes(55));
                $ba->move(public_path() . '/gfx/backgrounds/', $newName . '.' . $ba->getClientOriginalExtension());

                if (AppModel::getImageType(public_path() . '/gfx/backgrounds/' . $newName . '.' . $ba->getClientOriginalExtension()) === null) {
                    unlink(public_path() . '/gfx/backgrounds/', $newName . '.' . $ba->getClientOriginalExtension());
                    throw new \Exception(__('app.invalid_image_file'));
                }

                AppModel::saveSetting('backgroundImage', $newName . '.' . $ba->getClientOriginalExtension());

                return back()->with('flash.success', __('app.data_saved'));
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Lock (deactivate) user account
     * 
     * @param $id
     * @return mixed
     */
    public function lockUser($id)
    {
        try {
            ReportModel::setSafe($id);

            $user = User::get($id);
            $user->deactivated = true;
            $user->save();

            return back()->with('flash.success', __('app.user_deactivated'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Set user safe
     * 
     * @param $id
     * @return mixed
     */
    public function setUserSafe($id)
    {
        try {
            ReportModel::setSafe($id);

            return back()->with('flash.success', __('app.user_now_safe'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Approve account
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveAccount($id)
    {
        try {
            $user = User::get($id);

            VerifyModel::verifyStatus($id, VerifyModel::STATE_VERIFIED);

            $html = view('mail.acc_verify', ['name' => $user->name, 'state' => __('app.account_verified'), 'reason' => '-'])->render();
            MailerModel::sendMail($user->email, __('app.mail_acc_verify_title'), $html);

            return back()->with('flash.success', __('app.account_verified'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Decline account
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function declineAccount($id)
    {
        try {
            $user = User::get($id);

            $reason = request('reason', '');

            VerifyModel::verifyStatus($id, VerifyModel::STATE_DECLINED, urldecode($reason));

            $html = view('mail.acc_verify', ['name' => $user->name, 'state' => __('app.account_verification_declined'), 'reason' => urldecode($reason)])->render();
            MailerModel::sendMail($user->email, __('app.mail_acc_verify_title'), $html);

            return back()->with('flash.success', __('app.account_verification_declined'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Approve user photo
     * 
     * @param $userId
     * @param $which
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approvePhoto($userId, $which)
    {
        try {
            PhotoApprovalModel::approve($userId, $which);

            return back()->with('flash.success', __('app.photo_approved'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Decline user photo
     * 
     * @param $userId
     * @param $which
     * @return \Illuminate\Http\RedirectResponse
     */
    public function declinePhoto($userId, $which)
    {
        try {
            PhotoApprovalModel::decline($userId, $which);

            return back()->with('flash.success', __('app.photo_declined'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Approve an event
     * 
     * @param $id
     * @return mixed
     */
    public function approveEvent($id)
    {
        try {
            $event = EventsModel::where('id', '=', $id)->first();
            if (!$event) {
                throw new \Exception('Event not found: ' . $id);
            }

            $event->initialApproved = true;
            $event->approved = true;
            $event->save();

            return back()->with('flash.success', __('app.event_approved'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Decline an event
     * 
     * @param $id
     * @return mixed
     */
    public function declineEvent($id)
    {
        try {
            $event = EventsModel::where('id', '=', $id)->first();
            if (!$event) {
                throw new \Exception('Event not found: ' . $id);
            }

            $comments = EventsThreadModel::where('eventId', '=', $id)->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }

            $participants = EventsParticipantsModel::where('eventId', '=', $id)->get();
            foreach ($participants as $participant) {
                $participant->delete();
            }

            $event->delete();

            return back()->with('flash.success', __('app.event_declined'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Create an announcement
     * 
     * @return mixed
     */
    public function createAnnouncement()
    {
        try {
            $attr = request()->validate([
                'title' => 'required',
                'content' => 'required',
                'until' => 'required|date'
            ]);

            AnnouncementsModel::add($attr['title'], $attr['content'], date('Y-m-d 23:59:59', strtotime($attr['until'])));

            return back()->with('flash.success', __('app.announcement_created'));
        } catch (\Exception $e) {
            return back()->with('flash.error', $e->getMessage());
        }
    }

    /**
     * Save theme
     * 
     * @return mixed
     */
    public function saveTheme()
    {
        try {
            $attr = request()->validate([
                'theme' => 'required'
            ]);

            AppModel::saveTheme($attr['theme']);

            return back()->with('flash.success', __('app.data_saved'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
