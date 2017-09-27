<?php

namespace App\Api\V1\Transformers;

use App\Character;
use App\SelectCharacter;
use App\Status;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Api\V1\Transformers
 */
class TotalCharacterTransformer extends TransformerAbstract
{

    /**
     * @param User $user
     */
    public function transform(SelectCharacter $selectcharacter)
    {

        $user = \Auth::user();

        $totalOwn = Character::whereIn('character.status_id', [Status::$ACTIVE, Status::$INACTIVE])
                ->join('select_character', 'select_character.character_id', '=', 'character.id')
                ->where('select_character.user_id', '=', $user->id)
                ->where('select_character.select_character', '=', 'own')
                ->select('character.*', 'character.value')->sum('character.value');


        $totalWant = Character::whereIn('character.status_id', [Status::$ACTIVE, Status::$INACTIVE])
            ->join('select_character', 'select_character.character_id', '=', 'character.id')
            ->where('select_character.user_id', '=', $user->id)
            ->where('select_character.select_character', '=', 'want')
            ->select('character.*', 'character.value')->sum('character.value');

        return [
            'total_own' => $totalOwn,
            'total_want' => $totalWant,
        ];
    }
}