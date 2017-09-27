<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $type
 * @property string $token
 * @property int $language_id
 * @property int $city_id
 * @property int $status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereLanguageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Model
{
    protected $table = 'admin';

}
