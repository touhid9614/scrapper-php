<?php

namespace sMedia\AdWords\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class: Car
 *
 * @property string $stock_number
 * @property string $stock_number
 * @property string $vin
 * @property string $stock_type
 * @property string $title
 * @property string $year
 * @property string $make
 * @property string $model
 * @property string $trim
 * @property string $msrp
 * @property string $price
 * @property string $city
 * @property string $biweekly
 * @property string $lease
 * @property string $lease_term
 * @property string $lease_rate
 * @property string $finance
 * @property string $finance_term
 * @property string $finance_rate
 * @property string $price_history
 * @property string $body_style
 * @property string $engine
 * @property string $transmission
 * @property string $fuel_type
 * @property string $drivetrain
 * @property string $exterior_color
 * @property string $interior_color
 * @property string $kilometres
 * @property string $all_images
 * @property string $auto_texts
 * @property string $description
 * @property string $url
 * @property string $host
 * @property string $arrival_date
 * @property string $updated_at
 * @property string $handled_at
 * @property string $bing_handled_at
 * @property string $certified
 * @property string $deleted
 * @property string $options
 * @property string $custom
 *
 * @see Model
 * @package sMedia\Adwords
 */
class Car extends Model
{
    protected $fillable = [
        'stock_number',
        'vin',
        'stock_type',
        'title',
        'year',
        'make',
        'model',
        'trim',
        'msrp',
        'price',
        'city',
        'biweekly',
        'lease',
        'lease_term',
        'lease_rate',
        'finance',
        'finance_term',
        'finance_rate',
        'price_history',
        'body_style',
        'engine',
        'transmission',
        'fuel_type',
        'drivetrain',
        'exterior_color',
        'interior_color',
        'kilometres',
        'all_images',
        'auto_texts',
        'description',
        'url',
        'host',
        'arrival_date',
        'updated_at',
        'handled_at',
        'bing_handled_at',
        'certified',
        'deleted',
        'options',
        'custom',
    ];

    public $timestamps = false;

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }
}
