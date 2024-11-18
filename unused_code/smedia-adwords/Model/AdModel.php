<?php

namespace sMedia\AdWords\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class: AdwordsAd
 *
 * @property string $title
 * @property string $title_2
 * @property string $title_3
 * @property string $description
 * @property string $description_2
 * @property string $campaign
 * @property string $ad_group
 * @property string $hash
 *
 * @see Model
 * @package sMedia\Adwords
 */
class AdModel extends Model
{
    protected $fillable = [
        'title',
        'title_2',
        'title_3',
        'description',
        'description_2',
        'campaign',
        'ad_group',
        'hash',
    ];

    public $timestamps = false;

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }
}
