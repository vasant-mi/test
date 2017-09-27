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
class CharacterTransformer extends TransformerAbstract
{

    /**
     * @param User $user
     */
    public function transform(Character $character)
    {

        $user = \Auth::user();

        $selectCharacter = SelectCharacter::wherecharacterId($character->id)->whereUserId($user->id)->whereStatusId(Status::$ACTIVE)->first();

        return [
            'id' => $character->id,
            'image' => $character->imageURL($character->image),
            'code' => $character->code,
            'value' => $character->value,
            'rarity_name' => $character->rarity_name,
            'team_name' => $character->team_name,
            'series_name' => $character->series_name,
            'found_name' => $character->title_name,
            'finish' => $character->finish,
            'available_only' => $character->available_only,
            'select_character' => (isset($selectCharacter->select_character)) ? $selectCharacter->select_character : null,
            'status_id' => $character->status_id
        ];
    }
}