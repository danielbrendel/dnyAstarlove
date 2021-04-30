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
use App\Models\IgnoreModel;
use App\Models\LikeModel;
use App\Models\MessageModel;
use App\Models\PushModel;
use App\Models\ReportModel;
use App\Models\VisitorModel;
use App\Models\VerifyModel;

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

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_DIVERSE = 3;

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
            $user->avatar_large = $user->avatar;
            $user->account_confirm = md5($attr['email'] . $attr['username'] . random_bytes(55));
            $user->language = env('APP_LANG', 'en');
            $user->save();

            $html = view('mail.registered', ['username' => $user->name, 'hash' => $user->account_confirm])->render();
            MailerModel::sendMail($user->email, __('app.mail_subject_register'), $html);

            PushModel::addNotification(__('app.register_welcome_short'), __('app.register_welcome_long', ['url' => url('/settings?tab=tabProfile')]), 'PUSH_WELCOME', $user->id);

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
                ->where('geo_exclude', '=', false)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->havingRaw('distance <= ?', [$range]);

            $gender = array();
            if ($male) {
                $gender[] = static::GENDER_MALE;
            }
            if ($female) {
                $gender[] = static::GENDER_FEMALE;
            }
            if ($diverse) {
                $gender[] = static::GENDER_DIVERSE;
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
                    case static::GENDER_MALE:
                        $item->gender = __('app.gender_male');
                        break;
                    case static::GENDER_FEMALE:
                        $item->gender = __('app.gender_female');
                        break;
                    case static::GENDER_DIVERSE:
                        $item->gender = __('app.gender_diverse');
                        break;
                    default:
                        $item->gender = __('app.gender_unspecified');
                        break;
                }

                $item->age = Carbon::parse($user->birthday)->age;
                $item->is_online = static::isMemberOnline($item->id);
                $item->verified = VerifyModel::getState($item->id) == VerifyModel::STATE_VERIFIED;
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

    /**
     * Save user profile data
     * 
     * @param $attr
     * @return void
     * @throws \Exception
     */
    public static function saveProfile($attr)
    {
        try {
            $user = static::getByAuthId();
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception('app.login_required');
            }

            if (!static::isValidNameIdent($attr['username'])) {
                throw new \Exception(__('app.invalid_username'));
            }

            if ($attr['username'] !== $user->name) {
                if (static::getByName($attr['username'])) {
                    throw new \Exception(__('app.name_already_in_use'));
                }
            }

            $user->name = $attr['username'];
            $user->realname = $attr['realname'];
            $user->birthday = $attr['birthday'];
            $user->gender = $attr['gender'];
            $user->height = $attr['height'];
            $user->weight = $attr['weight'];
            $user->rel_status = $attr['rel_status'];
            $user->location = $attr['location'];
            $user->job = $attr['job'];
            $user->introduction = \Purifier::clean($attr['introduction']);
            $user->interests = \Purifier::clean($attr['interests']);
            $user->music = \Purifier::clean($attr['music']);
            $user->language = $attr['language'];

            $user->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save user password
     * 
     * @param $pw
     * @param $confirm
     * @return void
     * @throws \Exception
     */
    public static function savePassword($pw, $confirm)
    {
        try {
            $user = static::getByAuthId();
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception('app.login_required');
            }

            if ($pw !== $confirm) {
                throw new \Exception(__('app.password_mismatch'));
            }

            $user->password = password_hash($pw, PASSWORD_BCRYPT);
            $user->save();

            $html = view('mail.pw_changed', ['name' => $user->name])->render();
            MailerModel::sendMail($user->email, __('app.password_changed'), $html);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save user e-mail address
     * 
     * @param $email
     * @return void
     * @throws \Exception
     */
    public static function saveEmail($email)
    {
        try {
            $user = static::getByAuthId();
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception(__('app.login_required'));
            }

            $oldMail = $user->email;

            $user->email = $email;
            $user->save();

            $html = view('mail.email_changed', ['name' => $user->name, 'email' => $email])->render();
            MailerModel::sendMail($user->email, __('app.email_changed'), $html);
            MailerModel::sendMail($oldMail, __('app.email_changed'), $html);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save geo exclude flag
     * 
     * @param $value
     * @return void
     * @throws \Exception
     */
    public static function saveGeoExclude($value)
    {
        try {
            $user = static::getByAuthId();
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception('app.login_required');
            }

            if (!$user->admin) {
                throw new \Exception(__('app.insufficient_permissions'));
            }

            $user->geo_exclude = $value;
            $user->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if file is a valid image
     *
     * @param string $imgFile
     * @return bool
     */
    public static function isValidImage($imgFile)
    {
        $imagetypes = array(
            IMAGETYPE_PNG,
            IMAGETYPE_JPEG,
            IMAGETYPE_GIF
        );

        if (!file_exists($imgFile)) {
            return false;
        }

        foreach ($imagetypes as $type) {
            if (exif_imagetype($imgFile) === $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get image type
     *
     * @param $ext
     * @param $file
     * @return mixed|null
     */
    public static function getImageType($ext, $file)
    {
        $imagetypes = array(
            array('png', IMAGETYPE_PNG),
            array('jpg', IMAGETYPE_JPEG),
            array('jpeg', IMAGETYPE_JPEG),
            array('gif', IMAGETYPE_GIF)
        );

        for ($i = 0; $i < count($imagetypes); $i++) {
            if (strtolower($ext) == $imagetypes[$i][0]) {
                if (exif_imagetype($file . '.' . $ext) == $imagetypes[$i][1])
                    return $imagetypes[$i][1];
            }
        }

        return null;
    }

    /**
     * Correct image rotation of uploaded image
     *
     * @param $filename
     * @param &$image
     * @return void
     */
    private static function correctImageRotation($filename, &$image)
    {
        $exif = @exif_read_data($filename);

        if (!isset($exif['Orientation']))
            return;

        switch($exif['Orientation'])
        {
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 6:
                $image = imagerotate($image, 270, 0);
                break;
            default:
                break;
        }
    }

    /**
     * Create thumb file of image
     *
     * @param $srcfile
     * @param $imgtype
     * @param $basefile
     * @param $fileext
     * @return bool
     */
    public static function createThumbFile($srcfile, $imgtype, $basefile, $fileext)
    {
        list($width, $height) = getimagesize($srcfile);

        $factor = 1.0;

        if ($width > $height) {
            if (($width >= 800) and ($width < 1000)) {
                $factor = 0.5;
            } else if (($width >= 1000) and ($width < 1250)) {
                $factor = 0.4;
            } else if (($width >= 1250) and ($width < 1500)) {
                $factor = 0.4;
            } else if (($width >= 1500) and ($width < 2000)) {
                $factor = 0.3;
            } else if ($width >= 2000) {
                $factor = 0.2;
            }
        } else {
            if (($height >= 800) and ($height < 1000)) {
                $factor = 0.5;
            } else if (($height >= 1000) and ($height < 1250)) {
                $factor = 0.4;
            } else if (($height >= 1250) and ($height < 1500)) {
                $factor = 0.4;
            } else if (($height >= 1500) and ($height < 2000)) {
                $factor = 0.3;
            } else if ($height >= 2000) {
                $factor = 0.2;
            }
        }

        $newwidth = $factor * $width;
        $newheight = $factor * $height;

        $dstimg = imagecreatetruecolor($newwidth, $newheight);
        if (!$dstimg)
            return false;

        $srcimage = null;
        switch ($imgtype) {
            case IMAGETYPE_PNG:
                $srcimage = imagecreatefrompng($srcfile);
                imagecopyresampled($dstimg, $srcimage, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                static::correctImageRotation($srcfile, $dstimg);
                imagepng($dstimg, $basefile . "_thumb." . $fileext);
                break;
            case IMAGETYPE_JPEG:
                $srcimage = imagecreatefromjpeg($srcfile);
                imagecopyresampled($dstimg, $srcimage, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                static::correctImageRotation($srcfile, $dstimg);
                imagejpeg($dstimg, $basefile . "_thumb." . $fileext);
                break;
            case IMAGETYPE_GIF:
                copy($srcfile, $basefile . "_thumb." . $fileext);
                break;
            default:
                return false;
                break;
        }

        return true;
    }

    /**
     * Save specific photo
     * 
     * @param $which
     * @return void
     * @throws \Exception
     */
    public static function savePhoto($which)
    {
        try {
            $user = static::getByAuthId();
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception('app.login_required');
            }

            $allowed = array('avatar', 'photo1', 'photo2', 'photo3');
            if (!in_array($which, $allowed)) {
                throw new \Exception('Invalid photo type: ' . $which);
            }

            $image = request()->file('image');
            if ($image !== null) {
                if ($image->getSize() > env('APP_MAXUPLOADSIZE')) {
                    throw new \Exception(__('app.post_upload_size_exceeded'));
                }

                $fname = uniqid('', true) . md5(random_bytes(55));
                $fext = $image->getClientOriginalExtension();

                $image->move(public_path() . '/gfx/avatars/', $fname . '.' . $fext);

                $baseFile = public_path() . '/gfx/avatars/' . $fname;
                $fullFile = $baseFile . '.' . $fext;

                if (!static::isValidImage(public_path() . '/gfx/avatars/' . $fname . '.' . $fext)) {
                    throw new \Exception('Invalid image uploaded');
                }

                if (!static::createThumbFile($fullFile, static::getImageType($fext, $baseFile), $baseFile, $fext)) {
                    throw new \Exception('createThumbFile failed', 500);
                }
                
                $large = $which . '_large';

                $user->$large = $fname . '.' . $fext;
                $user->$which = $fname . '_thumb.' . $fext;
                $user->save();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save notification settings
     * 
     * @param $attr
     * @return void
     * @throws \Exception
     */
    public static function saveNotifications($attr)
    {
        try {
            $user = static::getByAuthId();
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception('app.login_required');
            }

            $user->mail_on_message = $attr['mail_on_message'];
            $user->newsletter = $attr['newsletter'];
            $user->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if pro mode has expired of given user
     * 
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public static function promodeExpired($user)
    {
        try {
            if ($user->last_payed === null) {
                return true;
            }

            return Carbon::parse($user->last_payed)->diffInDays(Carbon::now()) > env('STRIPE_EXPIRE_DAY_COUNT', 90);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete user account
     * 
     * @param $userId
     * @return void
     * @throws \Exception
     */
    public static function deleteAccount($userId)
    {
        try {
            $user = User::where('id', '=', $userId)->first();
            if ((!$user) || ($user->deactivated)) {
                throw new \Exception('app.user_not_found_or_deactivated');
            }

            $ignores = IgnoreModel::where('userId', '=', $userId)->orWhere('targetId', '=', $userId)->get();
            foreach ($ignores as $item) {
                $item->delete();
            }

            $likes = LikeModel::where('userId', '=', $userId)->orWhere('likedUserId', '=', $userId)->get();
            foreach ($likes as $item) {
                $item->delete();
            }

            $messages = MessageModel::where('userId', '=', $userId)->orWhere('senderId', '=', $userId)->get();
            foreach ($messages as $item) {
                $item->delete();
            }

            $pushes = PushModel::where('userId', '=', $userId)->get();
            foreach ($pushes as $item) {
                $item->delete();
            }

            $reports = ReportModel::where('reporterId', '=', $userId)->orWhere('targetId', '=', $userId)->get();
            foreach ($reports as $item) {
                $item->delete();
            }

            $visitors = VisitorModel::where('visitorId', '=', $userId)->orWhere('visitedId', '=', $userId)->get();
            foreach ($visitors as $item) {
                $item->delete();
            }

            $user->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
