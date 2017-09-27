<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Character
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property int $code
 * @property int $range_id
 * @property int $series_id
 * @property int $team_id
 * @property int $rarity_id
 * @property string $finish
 * @property string $character_bio
 * @property string $found_in
 * @property string $value
 * @property int $available_usa_canada
 * @property int $status_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereAvailableUsaCanada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereCharacterBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereFinish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereFoundIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereRangeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereRarityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereSeriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Character whereValue($value)
 * @mixin \Eloquent
 */
class Character extends Model
{
    protected $table = 'character';

    public static function imageURL($img, $modificationParams = []){
        if (file_exists(storage_path('images/character/'.$img)) && $img != '') {
            return url(\GlideImage::load('images/character/' . $img, $modificationParams));
        }
        return url(\GlideImage::load('default_image.png',$modificationParams));
    }

    public static function characterOwn($userId){
        $totalOwn = Character::whereIn('character.status_id', [Status::$ACTIVE, Status::$INACTIVE])
            ->join('select_character', 'select_character.character_id', '=', 'character.id')
            ->where('select_character.user_id', '=', $userId)
            ->where('select_character.select_character', '=', 'own')
            ->select('character.*', 'character.value')->sum('character.value');
            return $totalOwn;
    }

    public static function characterWant($userId){
        $totalWant = Character::whereIn('character.status_id', [Status::$ACTIVE, Status::$INACTIVE])
            ->join('select_character', 'select_character.character_id', '=', 'character.id')
            ->where('select_character.user_id', '=', $userId)
            ->where('select_character.select_character', '=', 'want')
            ->select('character.*', 'character.value')->sum('character.value');
        return $totalWant;
    }
}
