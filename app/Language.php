<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Language
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    protected $table = 'language';

    public static $current;

    public static $ENGLISH = 1;
}
