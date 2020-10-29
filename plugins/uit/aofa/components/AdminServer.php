<?php namespace Uit\Aofa\Components;

use Cms\Classes\ComponentBase;
use Uit\Aofa\Models\Order;
use Uit\Aofa\Models\OrderType;
use Uit\Aofa\Models\Settings;
use Uit\Aofa\Models\Key;
use Input;
use Validator;
use ValidationException;
use System\Models\File;
use Config;
use ApplicationException;
use Lang;
use RainLab\Translate\Models\Message;

class AdminServer extends ComponentBase
{
    use \Uit\Aofa\Classes\ServiceTrait;

    public function componentDetails()
    {
        return [
            'name'        => 'adminServer Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onAdminServer()
    {
        if(session()->has('auth_key')) {
            $auth_key = session()->get('auth_key');
            $existsKey = \Uit\Aofa\Models\Key::where('key', $auth_key)->first();
            if(!is_null($existsKey)){
                if(!$existsKey->isActive()) {
                    return redirect()->to('locked');
                }
            }
        }else{
            return redirect()->to('login');
        }

        $data = Input::all()['data'];

        $rules = [];
        $attributes = [];

        $orderType = OrderType::findOrFail($data['order_type']);
        

        if (
            $orderType->fields
        ) {
            foreach ($orderType->fields as $field) {
                if ($field['rule'] && !empty($field['rule'])) {
                    $rules[$field['name']] = $field['rule'];
                }

                if ($field['label'] && !empty($field['label'])) {
                    $attributes[$field['name']] = Message::trans( $field['label'], [], null); 
                }
            }
        }

        $validator = Validator::make($data, $rules, [], $attributes);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $order = new Order();

        $formattedData = $data;

        foreach ($data as $key => $value) {
            if (is_a($value, 'Illuminate\Http\UploadedFile')) {
                $file = (new File())->fromPost($value);
                $formattedData[$key] = $file->path;
            }
            if (empty($value)) {
                unset($formattedData[$key]);
            }

            if($key == 'payment_type'){
                $formattedData[$key] = Config::get('uit.aofa::payment_types.'.$value);
            }
        }

        //Number(accountCount)*Number(countryPrice)

        if($data['admin_server'] == 'tnmanager'){
            $serverPrice = Settings::get('price_tnmanager_admin');
        }else{
            $serverPrice = Settings::get('price_sms_admin');
        }
        
        
   
        $total = $data['server_count']*$data['week_count']*$serverPrice;

        if($data['payment_type'] == 'balance'){
            if($this->getBalance() < $total) throw new ApplicationException(Lang::get('uit.aofa::lang.message.balance_enough')); //'Пожалуйста пополните баланс!'

            (new Key)->balanceMinus($this->getKey(), $total);
            $order->status_id = 2;
            
        }else{
            $order->status_id = 1;
        }

        unset($formattedData['order_type']);
     

        $order->type_id = $data['order_type'];
        $order->data = $formattedData;
        $order->total = $total;
        $order->key = $this->getKey();
      
        $order->save();

        return [
            '.container_message' => $this->renderPartial('@_message', [
                'type' => 'success',
                'message' => Lang::get('uit.aofa::lang.message.request_success'),
            ]),
        ];
    }

   
}
