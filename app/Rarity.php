<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Rarity
 *
 * @property int $id
 * @property string $title
 * @property int $status_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rarity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rarity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rarity whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rarity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rarity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rarity extends Model
{
    protected $table = 'rarity';
}
