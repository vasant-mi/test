<?php

namespace App\Api\V1\Transformers;

use App\Character;
use App\SelectCharacter;
use App\Status;
use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Api\V1\Transformers
 */
class UserCharacterTransformer extends TransformerAbstract
{

    /**
     * @param User $user
     */
    public function transform(User $user)
    {

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
            'id' => $user->id,
            'total_own' => $totalOwn,
            'total_want' => $totalWant
        ];
    }
}