<?php
namespace App\Api\V1\Controllers;
use App\Api\ApiController;
use App\Api\V1\Transformers\CityTransformer;
use App\Api\V1\Transformers\CountryTransformer;
use App\Api\V1\Transformers\LanguageTransformer;
use App\City;
use App\Country;
use App\Language;
use App\Status;

Class MasterController extends ApiController {
    public function countries(){
        $countries = Country::whereStatusId(Status::$ACTIVE)->get();
        return $this->response->collection($countries, new CountryTransformer)->setMeta([
            'status' => '200',
            'message' => __('api/master.countries_list')
        ]);
    }

    public function cities($countryId){
        $cities = City::whereCountryId($countryId)->whereStatusId(Status::$ACTIVE)->get();
        return $this->response->collection($cities, new CityTransformer)->setMeta([
            'status' => '200',
            'message' => __('api/master.cities_list')
        ]);
    }

    public function languages(){
        $languages = Language::whereStatusId(Status::$ACTIVE)->get();
        return $this->response->collection($languages, new LanguageTransformer)->setMeta([
            'status' => '200',
            'message' => __('api/master.languages_list')
        ]);
    }
}