<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Collector
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $middlename
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $birthday
 * @property string|null $has_citizenship
 * @property string|null $social_vk
 * @property string|null $social_fb
 * @property string|null $social_tw
 * @property string|null $status
 * @property string|null $reg_ip
 * @property string|null $ok_about_myinfo
 * @property string|null $aboutself
 * @property string|null $origin
 * @property string|null $utm_list
 * @property string|null $date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereAboutself($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereHasCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereOkAboutMyinfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereRegIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereSocialFb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereSocialTw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereSocialVk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereUtmList($value)
 * @mixin \Eloquent
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $research_status
 * @property string|null $research_comment
 * @property-read mixed $status_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereResearchComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereResearchStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereUpdatedAt($value)
 * @property string|null $comment
 * @property string|null $interview_date
 * @property-read mixed $research_status_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collector whereInterviewDate($value)
 */
class Collector extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'collectors_list';

    public function getCreatedAtColumn()
    {
        return "date";
    }

    public static function allStatuses()
    {
        $all = [
            "" => "",
            "new" => "Не проверен",
            "research" => "в рисёрче",
            "research_done" => "прошёл рисёрч",
            "interview_accespted" => "записан на собеседование",
            "accepted" => "принят",
            "declined" => "отклонён",
            "fired" => "уволен",
        ];
        return $all;
    }

    public static function researchStatuses()
    {
        $all = [
            "" => "",
            "declined" => "Отклонить",
            "attention" => "Осторожно",
            "approved" => "Нет проблем",
        ];
        return $all;
    }

    public function getStatusTextAttribute()
    {
        return self::allStatuses()[$this->status];
    }

    public function getResearchStatusTextAttribute()
    {
        return self::researchStatuses()[$this->research_status];
    }
}