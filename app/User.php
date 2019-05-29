<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $phone
 * @property string|null $email
 * @property string $role
 * @property string|null $ex_role
 * @property string $name
 * @property string $surname
 * @property string|null $middlename
 * @property string|null $extra_class
 * @property int|null $birthdate
 * @property string|null $uik_id
 * @property string|null $canton_small
 * @property int|null $living_address
 * @property int|null $building_id
 * @property string|null $street_name
 * @property string|null $house_number
 * @property int|null $entrance
 * @property string|null $social
 * @property string $password
 * @property string $salt
 * @property int|null $is_banned
 * @property string|null $reg_date
 * @property string|null $last_visit
 * @property string|null $last_activity
 * @property string|null $last_ip
 * @property int|null $referer_of
 * @property string|null $reg_method
 * @property string|null $session_hash
 * @property string|null $social_vk
 * @property string|null $social_fb
 * @property string|null $social_tw
 * @property string|null $social_ok
 * @property string|null $social_lj
 * @property string|null $telegram_login
 * @property string|null $region_name
 * @property string|null $extra_region_name
 * @property int|null $district
 * @property string|null $avatar
 * @property string|null $political_views
 * @property string|null $telegram_id
 * @property string|null $origin
 * @property string|null $utm_list
 * @property string|null $last_passrecovery
 * @property string $ok_about_myinfo
 * @property int|null $team_id
 * @property string $remember_token
 * @property string|null $last_flatwalk_update
 * @property string $aboutself
 * @property string|null $public_hash
 * @property string|null $last_auth_sms_at
 * @property string|null $sms_authin_code
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAboutself($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCantonSmall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEntrance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereExRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereExtraClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereExtraRegionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereHouseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastAuthSmsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastFlatwalkUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastPassrecovery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLivingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOkAboutMyinfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePoliticalViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePublicHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRefererOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRegDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRegMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRegionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSalt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSessionHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSmsAuthinCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialFb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialLj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialTw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialVk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStreetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTelegramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTelegramLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUikId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUtmList($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'main_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
