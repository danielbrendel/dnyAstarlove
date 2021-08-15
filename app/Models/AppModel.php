<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppModel
 *
 * Interface to app specific settings
 */
class AppModel extends Model
{
    use HasFactory;

    /**
     * Get application settings
     * 
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public static function getAppSettings($id = 1)
    {
        try {
            return static::where('id', '=', $id)->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get background image file name
     * 
     * @return string
     * @throws \Exception
     */
    public static function getBackground()
    {
        try {
            return static::getAppSettings()->backgroundImage;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get background alpha channel value
     * 
     * @return string
     * @throws \Exception
     */
    public static function getAlphaChannel()
    {
        try {
            return static::getAppSettings()->alphaChannel;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get registration info
     * 
     * @return string
     * @throws \Exception
     */
    public static function getRegInfo()
    {
        try {
            return static::getAppSettings()->reg_info;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get cookie consent text
     * 
     * @return string
     * @throws \Exception
     */
    public static function getCookieConsentText()
    {
        try {
            return static::getAppSettings()->cookie_consent;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get ToS content
     * 
     * @return string
     * @throws \Exception
     */
    public static function getTermsOfService()
    {
        try {
            return static::getAppSettings()->tos;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get imprint content
     * 
     * @return string
     * @throws \Exception
     */
    public static function getImprint()
    {
        try {
            return static::getAppSettings()->imprint;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get head code content
     * 
     * @return string
     * @throws \Exception
     */
    public static function getHeadCode()
    {
        try {
            $headCode = static::getAppSettings()->head_code;

            return ($headCode !== null) ? $headCode : '';
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get ad code content
     * 
     * @return string
     * @throws \Exception
     */
    public static function getAdCode()
    {
        try {
            $adCode = static::getAppSettings()->ad_code;

            return ($adCode !== null) ? $adCode : '';
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get list of available languages
     *
     * @return array
     * @throws \Exception
     */
    public static function getLanguageList()
    {
        try {
            $result = array();
            $files = scandir(base_path() . '/resources/lang');
            foreach ($files as $file) {
                if (($file[0] !== '.') && (is_dir(base_path() . '/resources/lang/' . $file))) {
                    $result[] = $file;
                }
            }

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save about data
     * 
     * @param $attr
     * @return void
     * @throws \Exception
     */
    public static function saveAbout($attr)
    {
        try {
            $settings = static::getAppSettings();
            $settings->headline = $attr['headline'];
            $settings->subline = $attr['subline'];
            $settings->description = $attr['description'];
            $settings->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save specific setting
     * 
     * @param $ident
     * @param $value
     * @return void
     * @throws \Exception
     */
    public static function saveSetting($ident, $value)
    {
        try {
            $settings = static::getAppSettings();
            $settings->$ident = $value;
            $settings->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get image type of file
     *
     * @param $file
     * @return mixed|null
     */
    public static function getImageType($file)
    {
        $imagetypes = array(
            array('png', IMAGETYPE_PNG),
            array('jpg', IMAGETYPE_JPEG),
            array('jpeg', IMAGETYPE_JPEG)
        );

        for ($i = 0; $i < count($imagetypes); $i++) {
            if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) == $imagetypes[$i][0]) {
                if (exif_imagetype($file) == $imagetypes[$i][1])
                    return $imagetypes[$i][1];
            }
        }

        return null;
    }

    /**
     * Create a HelpRealm ticket
     *
     * @param $name
     * @param $email
     * @param $subject
     * @param $body
     * @return void
     * @throws Exception
     */
    public static function createTicket($name, $email, $subject, $body)
    {
        try {
            if (!env('HELPREALM_ENABLE')) {
                throw new \Exception(__('app.contact_feature_disabled'));
            }

            $postFields = [
                'apitoken' => env('HELPREALM_TOKEN'),
                'subject' => $subject,
                'text' => $body,
                'name' => $name,
                'email' => $email,
                'type' => env('HELPREALM_TICKETTYPEID'),
                'prio' => '1',
                'attachment' => null
            ];

            $ch = curl_init("https://helprealm.io/api/" . env('HELPREALM_WORKSPACE') . '/ticket/create');

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

            $response = curl_exec($ch);
            if(curl_error($ch)) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }

            curl_close($ch);

            $json = json_decode($response);
            if ($json->code !== 201) {
                throw new \Exception('Backend returned error ' . ((isset($json->data->invalid_fields)) ? print_r($json->data->invalid_fields, true) : ''), $json->code);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Initialize newsletter sending
     *
     * @param $subject
     * @param $content
     * @return void
     * @throws Exception
     */
    public static function initNewsletter($subject, $content)
    {
        try {
            $token = md5($subject . $content . random_bytes(55));

            static::saveSetting('newsletter_token', $token);
            static::saveSetting('newsletter_subject', $subject);
            static::saveSetting('newsletter_content', $content);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Process newsletter job
     *
     * @return array
     * @throws Exception
     */
    public static function newsletterJob()
    {
        try {
            $result = array();

            $settings = static::getAppSettings();
            if ($settings->newsletter_token !== null) {
                $users = User::where('deactivated', '=', false)->where('account_confirm', '=', '_confirmed')->where('newsletter', '=', true)->where('newsletter_token', '<>', $settings->newsletter_token)->limit(env('APP_NEWSLETTER_UCOUNT'))->get();
                foreach ($users as $user) {
                    $user->newsletter_token = $settings->newsletter_token;
                    $user->save();

                    MailerModel::sendMail($user->email, $settings->newsletter_subject, $settings->newsletter_content);

                    $result[] = array('username' => $user->name, 'email' => $user->email, 'sent_date' => date('Y-m-d H:i:s'));
                }
            }

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Generate a random password
     *
     * @param $length
     * @return string
     * @throws \Exception
     */
    public static function getRandomPassword($length)
    {
        try {
            $chars = 'abcdefghijklmnopqrstuvwxyz1234567890%$!';

            $result = '';

            for ($i = 0; $i < $length; $i++) {
                $result .= $chars[rand(0, strlen($chars) - 1)];
            }

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save env content
     *
     * @return void
     * @throws \Exception
     */
    public static function saveEnvironmentConfig()
    {
        try {
            $content = '# ' . env('APP_NAME') . ' environment configuration' . PHP_EOL;

            foreach ($_ENV as $key => $value) {
                $type = gettype($value);
                if ($type === 'string') {
                    $content .= $key . '="' . $value . '"' . PHP_EOL;
                } else {
                    if ($type === 'bool') {
                        $content .= $key = '=' . (($value) ? 'true' : 'false') . '' . PHP_EOL;
                    } else {
                        $content .= $key = '=' . $value . '' . PHP_EOL;
                    }
                }
            }

            $entire = file_get_contents(base_path() . '/.env') . PHP_EOL . $content;

            file_put_contents(base_path() . '/.env', $entire);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get current theme
     * 
     * @return string
     * @throws \Exception
     */
    public static function getCurrentTheme()
    {
        try {
            return static::getAppSettings()->theme;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get includable theme full file name
     * 
     * @return string
     * @throws \Exception
     */
    public static function getIncludableTheme()
    {
        try {
            $theme = static::getAppSettings()->theme;

            if ($theme === '_default') {
                return asset('css/app.css');
            }

            return asset('css/themes/' . $theme . '.css');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get list of themes
     * 
     * @return array
     * @throws \Exception
     */
    public static function getThemeList()
    {
        try {
            $list = array();
            $list[] = '_default';

            $files = scandir(public_path() . '/css/themes');
            foreach ($files as $file) {
                $ext = pathinfo(public_path() . '/css/themes/' . $file, PATHINFO_EXTENSION);
                if ($ext === 'css') {
                    $list[] = pathinfo(public_path() . '/css/themes/' . $file, PATHINFO_FILENAME);
                }
            }

            return $list;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save theme
     * 
     * @param $theme
     * @return void
     * @throws \Exception
     */
    public static function saveTheme($theme)
    {
        try {
            $settings = static::getAppSettings();
            $settings->theme = $theme;
            $settings->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
