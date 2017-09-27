<?php

namespace App\Api\V1\Controllers;

use App\Api\ApiController;
use App\Api\V1\Transformers\CharacterTransformer;
use App\Api\V1\Transformers\CountryTransformer;
use App\Api\V1\Transformers\SelectCharacterTransformer;
use App\Api\V1\Transformers\UserCharacterTransformer;
use App\Api\V1\Transformers\UserTransformer;
use App\Character;
use App\Country;
use App\Mail\ForgotPasswordMail;
use App\Mail\VerificationCodeMail;
use App\SelectCharacter;
use App\Status;
use App\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;

Class CharacterController extends ApiController
{

    public function character(Request $request)
    {

        $range = $request->get('range_id');
        $series = $request->get('series_id');
        $team = $request->get('team_id');
        $rarity = $request->get('rarity_id');

        if (isset($range) || isset($series) || isset($team) || isset($rarity)) {
            $character = Character::whereStatusId(Status::$ACTIVE)->whereIn('range_id', explode(',', $range))
                ->orWhereIn('series_id', explode(',', $series))
                ->orWhereIn('team_id', explode(',', $team))
                ->orWhereIn('rarity_id', explode(',', $rarity));
        } else {
            $character = Character::where('character.status_id','=', Status::$ACTIVE)
                ->join('rarity', 'rarity.id', '=', 'character.rarity_id')
                ->join('range', 'range.id', '=', 'character.range_id')
                ->join('team', 'team.id', '=', 'character.team_id')
                ->join('series', 'series.id', '=', 'character.series_id')
                ->select('character.*', 'rarity.title as rarity_name', 'range.title as range_name', 'team.title as team_name', 'series.title as series_name', \DB::raw('(select group_concat(found_in_package.title) from found_in_package where find_in_set(found_in_package.id, character.found_in)) as title_name'))
                ->orderBy('character.id', 'character.desc');
        }

        $character = $character->paginate($request->get('per_page', 10));

        return $this->response->paginator($character, new CharacterTransformer())->setMeta([
            'status' => '200',
            'message' => __('api/character.character_successfully')
        ]);
    }

    public function selectCharacter(Request $request)
    {

        $this->validateRequest('select_character');
        $requestParams = $request->only(['character_id', 'select_character']);
        $user = \Auth::user();

        $selectCharacter = SelectCharacter::wherecharacterId($requestParams['character_id'])->whereUserId($user->id)->whereStatusId(Status::$ACTIVE)->first();


        if(!$selectCharacter){
            $selectCharacter = new SelectCharacter();
        }

        $selectCharacter->character_id = $requestParams['character_id'];
        $selectCharacter->select_character = $requestParams['select_character'];
        $selectCharacter->user_id = $user->id;
        $selectCharacter->status_id = Status::$ACTIVE;
        $selectCharacter->save();

        return $this->response->item($selectCharacter, new SelectCharacterTransformer())->setMeta([
            'status' => '200',
            'message' => __('api/character.character_add_successfully')
        ]);
    }

    public function userCharacter(Request $request){

        $user = \Auth::user();
        return $this->response->item($user, new UserCharacterTransformer())->setMeta([
            'status' => '200',
            'message' => __('api/character.character_user_successfully')
        ]);

    }
}