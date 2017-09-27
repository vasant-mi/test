<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Cms
 *
 * @property int $id
 * @property string $title
 * @property int $status_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CmsTranslations[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $seo_url
 * @property string $cms_desc
 * @property string $meta_keyword
 * @property string $meta_desc
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereCmsDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereMetaDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereMetaKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cms whereSeoUrl($value)
 */
class Cms extends Model
{
    protected $table = 'cms';

    /**
     * @param int $languageId
     * @return CmsTranslations
     */
}
