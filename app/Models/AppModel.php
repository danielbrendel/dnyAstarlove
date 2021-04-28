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
                throw new Exception('Backend returned error ' . ((isset($json->data->invalid_fields)) ? print_r($json->data->invalid_fields, true) : ''), $json->code);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
