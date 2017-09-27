<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Series
 *
 * @property int $id
 * @property string $title
 * @property int $status_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Series extends Model
{
    protected $table = 'series';
}
