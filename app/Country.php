<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Country
 *
 * @property int $id
 * @property string $short_code
 * @property int $status_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CountryTranslations[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    protected $table = 'country';


    public function cities(){
        return $this->hasMany('\App\City');
    }
}
