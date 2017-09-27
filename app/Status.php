<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Status
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Status extends Model
{
    protected $table = 'status';

    public static $ACTIVE = 1;
    public static $INACTIVE = 2;
    public static $DELETED = 3;
    public static $UNVERIFIED = 4;
}
