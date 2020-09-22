<?php namespace Uit\Aofa\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Sushi\Sushi;

/**
 * Model
 */
class OrderStatus extends Model
{
    use Sushi;
    
    public function getRows()
    {
        return Config::get('uit.aofa::statuses', []);
    }
}
