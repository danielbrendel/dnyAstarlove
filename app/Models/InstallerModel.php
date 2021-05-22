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
 * Class InstallerModel
 * 
 * Installer specific processings
 */
class InstallerModel extends Model
{
    use HasFactory;

    /**
     * Perform installation process
     *
     * @param $attr
     * @return void
     * @throws Exception
     */
    public static function install($attr)
    {
        try {
            if (!file_exists(base_path() . '/do_install')) {
                throw new \Exception('Indicator file not found');
            }

            $envcontent = '# Astarlove Environment configuration' . PHP_EOL;
            $envcontent .= 'APP_NAME=Astarlove' . PHP_EOL;
            $envcontent .= 'APP_CODENAME=dnyAstarlove' . PHP_EOL;
            $envcontent .= 'APP_AUTHOR="Daniel Brendel"' . PHP_EOL;
            $envcontent .= 'APP_CONTACT="dbrendel1988@gmail.com"' . PHP_EOL;
            $envcontent .= 'APP_VERSION="1.0"' . PHP_EOL;
            $envcontent .= 'APP_ENV=production' . PHP_EOL;
            $envcontent .= 'APP_KEY=' . PHP_EOL;
            $envcontent .= 'APP_DEBUG=false' . PHP_EOL;
            $envcontent .= 'APP_URL="' . url('/') . '"' . PHP_EOL;
            $envcontent .= 'APP_DESCRIPTION="The Astarlove Dating System"' . PHP_EOL;
            $envcontent .= 'APP_KEYWORDS="daniel brendel, astarlove, dating, system, social, love"' . PHP_EOL;
            $envcontent .= 'APP_LANG="en"' . PHP_EOL;
            $envcontent .= 'APP_LASTREGPROFILESCOUNT=20' . PHP_EOL;
            $envcontent .= 'APP_ONLINEMINUTELIMIT=30' . PHP_EOL;
            $envcontent .= 'APP_KEYPHRASE="keyphrase"' . PHP_EOL;
            $envcontent .= 'APP_MAXUPLOADSIZE=30000000' . PHP_EOL;
            $envcontent .= 'APP_ENABLEADS=false' . PHP_EOL;
            $envcontent .= 'APP_VERIFICATIONCLEANUP=true' . PHP_EOL;
            $envcontent .= 'APP_NEWSLETTER_UCOUNT=5' . PHP_EOL;
            $envcontent .= 'APP_CRONPW="' . substr(md5(date('Y-m-d H:i:s') . random_bytes(55)), 0, 10) . '"' . PHP_EOL;
            $envcontent .= 'APP_MINREGISTERAGE=18' . PHP_EOL;
            $envcontent .= 'LOG_CHANNEL=stack' . PHP_EOL;
            $envcontent .= 'DB_CONNECTION=mysql' . PHP_EOL;
            $envcontent .= 'DB_HOST="' . $attr['dbhost'] . '"' . PHP_EOL;
            $envcontent .= 'DB_PORT=' . $attr['dbport'] . PHP_EOL;
            $envcontent .= 'DB_DATABASE="' . $attr['database'] . '"' . PHP_EOL;
            $envcontent .= 'DB_USERNAME="' . $attr['dbuser'] . '"' . PHP_EOL;
            $envcontent .= 'DB_PASSWORD="' . $attr['dbpassword']. '"' . PHP_EOL;
            $envcontent .= 'SMTP_FROMADDRESS="' . $attr['smtpfromaddress'] . '"' . PHP_EOL;
            $envcontent .= 'SMTP_FROMNAME="${APP_NAME}"' . PHP_EOL;
            $envcontent .= 'SMTP_HOST="' . $attr['smtphost'] . '"' . PHP_EOL;
            $envcontent .= 'SMTP_USERNAME="' . $attr['smtpuser'] . '"' . PHP_EOL;
            $envcontent .= 'SMTP_PASSWORD="' . $attr['smtppassword'] . '"' . PHP_EOL;
			$envcontent .= 'TWITTER_NEWS=null' . PHP_EOL;
			$envcontent .= 'HELPREALM_WORKSPACE=null' . PHP_EOL;
			$envcontent .= 'HELPREALM_TOKEN=null' . PHP_EOL;
			$envcontent .= 'HELPREALM_TICKETTYPEID=' . PHP_EOL;
			$envcontent .= 'STRIPE_ENABLE=false' . PHP_EOL;
			$envcontent .= 'STRIPE_TOKEN_SECRET=' . PHP_EOL;
            $envcontent .= 'STRIPE_TOKEN_PUBLIC=' . PHP_EOL;
            $envcontent .= 'STRIPE_CURRENCY="usd"' . PHP_EOL;
			$envcontent .= 'STRIPE_COSTS_VALUE=1000' . PHP_EOL;
			$envcontent .= 'STRIPE_COSTS_LABEL="10.00$"' . PHP_EOL;
            $envcontent .= 'FIREBASE_ENABLE=false' . PHP_EOL;
            $envcontent .= 'FIREBASE_ENDPOINT="https://fcm.googleapis.com/fcm/send"' . PHP_EOL;
            $envcontent .= 'FIREBASE_KEY=' . PHP_EOL;
            $envcontent .= 'BROADCAST_DRIVER=log' . PHP_EOL;
            $envcontent .= 'CACHE_DRIVER=file' . PHP_EOL;
            $envcontent .= 'QUEUE_CONNECTION=sync' . PHP_EOL;
            $envcontent .= 'SESSION_DRIVER=file' . PHP_EOL;
            $envcontent .= 'SESSION_LIFETIME=5760' . PHP_EOL;

            file_put_contents(base_path() . '/.env', $envcontent);

            \Artisan::call('config:clear');
            \Artisan::call('key:generate');

            $dbobj = new \PDO('mysql:host=' . $attr['dbhost'], $attr['dbuser'], $attr['dbpassword']);
            $dbobj->exec('CREATE DATABASE IF NOT EXISTS `' . $attr['database'] . '`;');

            \Config::set('database.connections.mysql', [
                'host' => $attr['dbhost'],
                'port' => $attr['dbport'],
                'database' => $attr['database'],
                'username' => $attr['dbuser'],
                'password' => $attr['dbpassword'],
                'driver' => 'mysql',
                'url' => env('DATABASE_URL'),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([
                    \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                ]) : [],
            ]);

            \DB::reconnect();

            \Artisan::call('migrate:install');
            \Artisan::call('migrate:refresh', array('--path' => 'database/migrations', '--force' => true));

            \DB::insert("INSERT INTO app_models (headline, subline, description, reg_info, cookie_consent) VALUES('Headline', 'Subline', 'The description goes here', 'reg_info', 'cookie_consent')");

            $user = new User();
            $user->name = 'admin';
            $user->password = password_hash($attr['password'], PASSWORD_BCRYPT);
            $user->email = $attr['email'];
            $user->avatar = 'default.png';
            $user->avatar_large = $user->avatar;
            $user->account_confirm = '_confirmed';
            $user->language = 'en';
            $user->admin = true;
            $user->save();

            unlink(base_path() . '/do_install');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
