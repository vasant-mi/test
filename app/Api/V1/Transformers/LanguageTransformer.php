<?php

namespace App\Api\V1\Transformers;

use App\City;
use App\Language;
use League\Fractal\TransformerAbstract;

/**
 * Class LanguageTransformer
 * @package App\Api\V1\Transformers
 */
class LanguageTransformer extends TransformerAbstract
{

    /**
     * @param Language $language
     * @return array
     */
    public function transform(Language $language)
    {
        return [
            'id' => $language->id,
            'name' => $language->name,
            'code' => $language->code
        ];
    }
}