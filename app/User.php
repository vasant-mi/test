<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;




/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $email
 * @property string $parent_email
 * @property string $dob
 * @property int $age
 * @property int $own
 * @property int $want
 * @property string $own_spv
 * @property string $want_spv
 * @property int $country_id
 * @property int $status_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $available_usa_canada
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvailableUsaCanada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOwn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOwnSpv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereParentEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereWant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereWantSpv($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    protected $table = 'users';

    public static function userAge($dob){
        return Carbon::parse($dob)->diffInYears(Carbon::now());
    }

    public function selectCharacter(){
        return $this->hasMany('\App\SelectCharacter');
    }

    public function sumOfCharacter($type){
        return $this->selectCharacter->filter(function(\App\SelectCharacter $selectCharacter) use ($type){
            return $selectCharacter->select_character == $type;
        })->map(function(\App\SelectCharacter $selectCharacter){
            return $selectCharacter->character ? $selectCharacter->character->value : 0;
        })->sum();
    }

    public function countOfCharacter($type){
        return $this->selectCharacter->filter(function(\App\SelectCharacter $selectCharacter) use ($type){
            return $selectCharacter->select_character == $type;
        })->map(function(\App\SelectCharacter $selectCharacter){
            return $selectCharacter->character ? $selectCharacter->character->value : 0;
        })->count();
    }
}
