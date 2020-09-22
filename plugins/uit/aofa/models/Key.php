<?php namespace Uit\Aofa\Models;

use Model;

/**
 * Model
 */
class Key extends Model
{
    use \October\Rain\Database\Traits\Validation;


    protected $dates = [
        'tn_manager_end',
        'sms_service_end'
    ];

    const STATUS = [
        0 => 'Заблокирован',
        1 => 'Активен'
    ];
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_aofa_keys';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getStatusNameAttribute(){
        return self::STATUS[$this->status];
    }

    public function isActive(){
        return ($this->status == 1)?true:false;
    }

    public function balanceMinus($key, $balance){
        $key = Key::where('key', $key)->first()->decrement('balance', $balance);
    }
}
