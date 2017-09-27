<?php

namespace App\Api\V1\Transformers;

use App\Country;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Api\V1\Transformers
 */
class CountryTransformer extends TransformerAbstract
{

    /**
     * @param User $user
     */
    public function transform(Country $country)
    {
        return [
            'id' => $country->id,
            'name' => $country->name,
            'short_code' => $country->short_code,
            'status_id' => $country->status_id,
            'created_at' => Carbon::parse($country->updated_at)->timestamp,
            'updated_at' => Carbon::parse($country->created_at)->timestamp
        ];
    }
}