<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
}
