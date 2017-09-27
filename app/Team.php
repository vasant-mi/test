<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Team
 *
 * @property int $id
 * @property string $title
 * @property int $status_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Team extends Model
{
    protected $table = 'team';
}
