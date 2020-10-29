<?php namespace Uit\Aofa\Models;

use Model;
use Config;
use System\Models\File;
/**
 * Model
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    protected $jsonable = ['data'];

    const ORDER_STATUS = [
        'PROCESSING' => 1,
        'PAYED' => 2,
        'INPROGRESS' => 3,
        'COMPLETED' => 4,
        'DECLINED' => 5,
    ];
    
    const ORDER_TYPES = [
        'BUY_ACCOUNT' => 1,
        'RESTORE_ACCOUNT' => 2,
        'RENEW_ARENDA' => 3,
        'REGISTER_SESSION' => 4,
        'ADD_BALANCE' => 5,
        'ADMIN_SERVER' => 6,
    ];
    


    protected $fillable = [
        'total',
        'type_id',
        'data',
        'status_id',
        'type_id'
    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_aofa_orders';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];


    public $attachMany = [
        'files' => 'System\Models\File',
        'notvalidfiles' => 'System\Models\File',   
    ];

    public function getTypeIdOptions(){
        return OrderType::pluck('label','id')->toArray();;
    }

    public function getStatusIdOptions(){
        return OrderStatus::pluck('name','id')->toArray();
    }

    public function getTypeAttribute(){
        return OrderType::find($this->type_id);
    }

    public function getStatusAttribute(){
        return OrderStatus::find($this->status_id);
    }


    public function afterUpdate()
    {
        if ($this->type_id == self::ORDER_TYPES['ADD_BALANCE']  && $this->status_id != $this->original['status_id'] && $this->status_id==self::ORDER_STATUS['COMPLETED']) {
           
           $key = Key::where('key', $this->key)->first();
           if($key){
                $key->balance =  $key->balance + $this->data['payment_sum'];
                $key->save();
           }
        }
    }


    public function getPosition(){
        $position = 0;
        if ($this->type_id == self::ORDER_TYPES['BUY_ACCOUNT'] && $this->status_id == self::ORDER_STATUS['PAYED'] 
         || $this->type_id == self::ORDER_TYPES['RESTORE_ACCOUNT'] && $this->status_id == self::ORDER_STATUS['PAYED']
         || $this->type_id == self::ORDER_TYPES['REGISTER_SESSION'] && $this->status_id == self::ORDER_STATUS['PAYED']
         
         ){
            $orders = self::where('status_id', $this->status_id)->where('type_id', $this->type_id)->orderBy('created_at', 'asc')->get();
       
            $position = $orders->search(function($order) {
                return $order->id === $this->id;
            });

        }
        return $position+1;
    }

    public function scopeBystatus($query, $status_id){
        return $query->where('status_id', $status_id);
    }




    public function fileLinesCount($id){
        $file = File::find($id);

        if($file){
            $path = $file->path;
            $linecount = 0;
            $handle = fopen($path, "r");
                while(!feof($handle)){
                $line = fgets($handle);
                $linecount++;
            }

            fclose($handle);
        }

        return $linecount;
    }


}
