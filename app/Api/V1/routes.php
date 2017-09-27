<?php
/**
 * Api v1 Routes File.
 *
 * @var $api \Dingo\Api\Routing\Router
 */


$api->post('signup', 'UserController@signup'); //COMPLETE
$api->post('login', 'UserController@login'); //COMPLETE
$api->post('forgot-password', 'UserController@forgotPassword');
$api->get('countries', 'UserController@countries');

$api->group(['middleware' => 'api.auth'], function (\Dingo\Api\Routing\Router $api) {
    $api->post('change-password', 'UserController@changePassword'); //COMPLETE
    $api->post('change-profile', 'UserController@changeProfile'); //COMPLETE
    $api->post('character', 'CharacterController@character'); //COMPLETE
    $api->post('select-character', 'CharacterController@selectCharacter'); //COMPLETE
    $api->get('user-character', 'CharacterController@userCharacter'); //COMPLETE
});