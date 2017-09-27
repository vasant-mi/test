<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Range
 *
 * @property int $id
 * @property string $title
 * @property int $status_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Range whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Range whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Range whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Range whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Range whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Range extends Model
{
    protected $table = 'range';
}
