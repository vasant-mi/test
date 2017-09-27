<?php

namespace App\Api\V1\Transformers;

use App\City;
use League\Fractal\TransformerAbstract;

/**
 * Class CityTransformer
 * @package App\Api\V1\Transformers
 */
class CityTransformer extends TransformerAbstract
{

    /**
     * @param City $city
     * @return array
     */
    public function transform(City $city)
    {
        $language = $city->language();
        return [
            'id' => $city->id,
            'name' => $language ? $language->name : '',
        ];
    }
}