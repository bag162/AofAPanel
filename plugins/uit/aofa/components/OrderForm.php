<?php namespace Uit\Aofa\Components;

use Cms\Classes\ComponentBase;
use Uit\Aofa\Models\Order;
use Uit\Aofa\Models\OrderType;
use Input;
use Validator;
use ValidationException;
use System\Models\File;
use Config;
use Lang;
use RainLab\Translate\Models\Message;

class OrderForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'OrderForm Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function init(){
        $types = Config::get('uit.aofa::types', []);

        foreach($types as $type){
            if($type['id'] != 7){
                
                $this->addComponent("Uit\Aofa\Components\\".$type['component'], $type['component'],[]);
            }
        }
       
        
    }

    public function onRun(){
        $this->page['orderTypes'] = Config::get('uit.aofa::types', []);
    }

 

    public function onSubmitOrder(){
        $data = Input::all()['data'];

        $rules = [];
        $attributes = [];

        $orderType = OrderType::findOrFail($data['order_type']);

        if($orderType->validation_rules && is_array($orderType->validation_rules)){
            foreach($orderType->validation_rules as $vrules){
                if(isset($vrules['field']) && isset($vrules['rule'])){
                    $rules[$vrules['field']] = $vrules['rule'];
                }

                if(isset($vrules['label'])){
                    $attributes[$vrules['field']] = Message::trans( $vrules['label'], [], null); 
                }
            }
        }
        

        $validator = Validator::make(
            $data, $rules, [], $attributes
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $order = new Order();

        $formattedData = $data;  
        
       
        foreach($data as $key => $value){
            if(is_a($value,'Illuminate\Http\UploadedFile') ){
                $file = (new File())->fromPost($value);
                $formattedData[$key] = $file->path;
            }
            if(empty($value)){
                unset($formattedData[$key]);
            }
        }
        
        $total = isset($data['total'])?$data['total']:0;

        unset($formattedData['order_type']);
        unset($formattedData['total']);

        $order->type_id = $data['order_type'];
        $order->data = $formattedData;
        $order->total = $total;
        $order->key = $this->getKey();
        $order->status_id = 1;
        $order->save();

        return ['.container_message' => $this->renderPartial('@_message', ['type' => 'success', 'message' => Lang::get('uit.aofa::lang.message.request_success'),])];


    }

    public function onFileLineCount(){
        $data = Input::all()['data'];

        $file = $data['recover_file']->path();

        $linecount = 0;
        $handle = fopen($file, "r");
            while(!feof($handle)){
            $line = fgets($handle);
            $linecount++;
        }

        fclose($handle);

        return ['#recovery_line_count' => $linecount];



        // $file = (new File())->fromPost($data);
        // $formattedData[$key] = $file->path;
        
    }


    public function getKey(){
        return session()->get('auth_key');
    }
}
