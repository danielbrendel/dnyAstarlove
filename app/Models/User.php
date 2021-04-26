<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Class User
 *
 * Interface to user specific operations
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * @var int
     */
    const INTRODUCTION_SHORT_DISPLAY_LEN = 145;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get last registered members
     * 
     * @param $count
     * @return mixed
     * @throws \Exception
     */
    public static function getLastRegisteredMembers($count)
    {
        try {
            return static::orderBy('id', 'desc')->limit($count)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Determine if a member is online
     * 
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public static function isMemberOnline($id)
    {
        try {
            $user = static::where('id', '=', $id)->first();
            if (!$user) {
                return false;
            }

            return Carbon::parse($user->last_action)->diffInMinutes() <= env('APP_ONLINEMINUTELIMIT', 30);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get user by ID
     * 
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public static function get($id)
    {
        try {
            return static::where('id', '=', $id)->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get user by name
     * 
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public static function getByName($name)
    {
        try {
            return static::where('name', '=', $name)->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get user by e-mail
     * 
     * @param $email
     * @return mixed
     * @throws \Exception
     */
    public static function getByEmail($email)
    {
        try {
            return static::where('email', '=', $email)->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get user by auth id
     * 
     * @return mixed
     * @throws \Exception
     */
    public static function getByAuthId()
    {
        try {
            return static::where('id', '=', auth()->id())->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Indicate if a user is an admin
     * 
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    public static function isAdmin($userId)
    {
        try {
            return static::where('id', '=', $userId)->where('admin', '=', true)->count() === 1;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Return if string is a valid identifier for user name
     * 
     * @param $ident
     * @return mixed
     */
    public static function isValidNameIdent($ident)
    {
        if (is_numeric($ident) || (strlen($ident) == 0)) {
            return false;
        }

        return !preg_match('/[^a-z_\-0-9]/i', $ident);
    }

    /**
     * Perform user registration
     * 
     * @param array $attr
     * @return int
     * @throws \Exception
     */
    public static function register($attr)
    {
        try {
            if (!\Auth::guest()) {
                throw new \Exception(__('app.register_already_signed_in'));
            }

            $attr['username'] = trim(strtolower($attr['username']));

            if ($attr['password'] !== $attr['password_confirmation']) {
                throw new \Exception(__('app.passwords_mismatch'));
            }

            $sum = CaptchaModel::querySum(session()->getId());
            if ($attr['captcha'] !== $sum) {
                throw new \Exception(__('app.register_captcha_invalid'));
            }

            if (static::getByEmail($attr['email'])) {
                throw new \Exception(__('app.register_email_in_use'));
            }

            if (static::getByName($attr['username'])) {
                throw new \Exception(__('app.register_username_in_use'));
            }

            if (!static::isValidNameIdent($attr['username'])) {
                throw new \Exception(__('app.register_username_invalid_chars'));
            }

            $user = new User();
            $user->name = $attr['username'];
            $user->password = password_hash($attr['password'], PASSWORD_BCRYPT);
            $user->email = $attr['email'];
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->avatar = 'default.png';
            $user->account_confirm = md5($attr['email'] . $attr['username'] . random_bytes(55));
            $user->save();

            $html = view('mail.registered', ['username' => $user->name, 'hash' => $user->account_confirm])->render();
            MailerModel::sendMail($user->email, __('app.mail_subject_register'), $html);

            return $user->id;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Resend account confirmation link
     *
     * @param $id
     * @throws \Exception
     */
    public static function resend($id)
    {
        try {
            $user = static::where('id', '=', $id)->where('account_confirm', '<>', '_confirmed')->first();
            if (!$user) {
                throw new \Exception(__('app.user_id_not_found_or_already_confirmed', ['id' => $id]));
            }

            $html = view('mail.registered', ['username' => $user->username, 'hash' => $user->account_confirm])->render();
            MailerModel::sendMail($user->email, __('app.mail_subject_register'), $html);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Confirm account
     *
     * @param $hash
     * @throws \Exception
     */
    public static function confirm($hash)
    {
        try {
            $user = static::where('account_confirm', '=', $hash)->first();
            if ($user === null) {
                throw new \Exception(__('app.register_confirm_token_not_found'));
            }

            $user->account_confirm = '_confirmed';
            $user->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Initialize password recovery
     *
     * @param $email
     * @throws \Exception
     */
    public static function recover($email)
    {
        try {
            $user = static::getByEmail($email);
            if (!$user) {
                throw new \Exception(__('app.email_not_found'));
            }

            $user->password_reset = md5($user->email . date('c') . uniqid('', true));
            $user->save();

            $htmlCode = view('mail.pwreset', ['username' => $user->username, 'hash' => $user->password_reset])->render();
            MailerModel::sendMail($user->email, __('app.mail_password_reset_subject'), $htmlCode);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Perform password reset
     *
     * @param $password
     * @param $password_confirm
     * @param $hash
     * @throws \Exception
     */
    public static function reset($password, $password_confirm, $hash)
    {
        try {
            if ($password != $password_confirm) {
                throw new \Exception(__('app.password_mismatch'));
            }

            $user = static::where('password_reset', '=', $hash)->first();
            if (!$user) {
                throw new \Exception(__('app.hash_not_found'));
            }

            $user->password = password_hash($password, PASSWORD_BCRYPT);
            $user->password_reset = '';
            $user->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Query user profiles
     * 
     * @param $range
     * @param $male
     * @param $female
     * @param $diverse
     * @param $from
     * @param $till
     * @param $online
     * @param $paginate
     * @return array
     * @throws \Exception
     */
    public static function queryProfiles($range, $male, $female, $diverse, $from, $till, $online, $paginate = null)
    {
        try {
            $user = static::getByAuthId();

            $query = \DB::table(with(new self)->getTable())
                ->select(\DB::raw('id, name, avatar, birthday, gender, realname, rel_status, last_action, introduction, location, latitude, longitude, SQRT(POW(69.1 * (latitude - ' . $user->latitude . '), 2) + POW(69.1 * (' . $user->longitude . ' - longitude) * COS(latitude / 57.3), 2)) AS distance'))
                ->where('deactivated', '=', false)
                ->where('account_confirm', '=', '_confirmed')
                ->where('id', '<>', $user->id)
                ->havingRaw('distance <= ?', [$range]);

            $gender = array();
            if ($male) {
                $gender[] = 1;
            }
            if ($female) {
                $gender[] = 2;
            }
            if ($diverse) {
                $gender[] = 3;
            }

            $query->whereRaw('(gender IN (' . implode(',', $gender) . '))');

            if (($from !== null) && (is_numeric($from))) {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birthday, CURDATE()) >= ?', [(int)$from]);
            }

            if (($till !== null) && (is_numeric($till))) {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birthday, CURDATE()) <= ?', [(int)$till]);
            }

            if ($online) {
                $query->whereRaw('TIMESTAMPDIFF(MINUTE, last_action, CURDATE()) <= ?', [(int)env('APP_ONLINEMINUTELIMIT', 30)]);
            }

            if ($paginate !== null) {
                $query->where('last_action', '<', $paginate);
            }

            $query->orderBy('last_action', 'desc')->limit(env('APP_MAXUSERPACK', 30));

            $items = $query->get();

            foreach ($items as &$item) {
                if (strlen($item->introduction) >= self::INTRODUCTION_SHORT_DISPLAY_LEN) {
                    $item->introduction = substr($item->introduction, 0, self::INTRODUCTION_SHORT_DISPLAY_LEN) . ' ...';
                }

                switch ($item->gender) {
                    case 1:
                        $item->gender = __('app.gender_male');
                        break;
                    case 2:
                        $item->gender = __('app.gender_female');
                        break;
                    case 3:
                        $item->gender = __('app.gender_diverse');
                        break;
                    default:
                        $item->gender = __('app.gender_unspecified');
                        break;
                }

                $item->age = Carbon::parse($user->birthday)->age;

                $item->is_online = static::isMemberOnline($item->id);
            }

            return $items->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save geo position of user
     *
     * @param $latitude
     * @param $longitude
     * @return void
     * @throws Exception
     */
    public static function storeGeoLocation($latitude, $longitude)
    {
        try {
            $item = static::where('deactivated', '=', false)->where('id', '=', auth()->id())->first();
            if (!$item) {
                throw new \Exception(__('app.user_not_found_or_deactivated'));
            }

            $item->latitude = $latitude;
            $item->longitude = $longitude;
            $item->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
