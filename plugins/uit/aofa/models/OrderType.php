<?php namespace Uit\Aofa\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Sushi\Sushi;

/**
 * Model
 */
class OrderType extends Model
{
    use Sushi;

    // protected $rows = [];

    public function getRows()
    {
        return Config::get('uit.aofa::types', []);
    }

    public function getFieldsAttribute()
    {
        return collect(json_decode($this->attributes['fields'], true));
    }
   
}
