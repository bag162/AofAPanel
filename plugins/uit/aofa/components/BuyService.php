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
use Multiwebinc\Recaptcha\Validators\RecaptchaValidator;


class BuyService extends ComponentBase
{
    use \Uit\Aofa\Classes\ServiceTrait;

    public function componentDetails()
    {
        return [
            'name'        => 'BuyService Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onBuyService()
    {
    

        $data = Input::all()['data'];
        $data['g-recaptcha-response'] = post('g-recaptcha-response');

        $rules = [];
        $attributes = [];

        $orderType = OrderType::findOrFail($data['order_type']);

        $rules['g-recaptcha-response']  = [
            'required',
            new RecaptchaValidator,
        ];

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
        // $countries = collect(Settings::get('countries'));
   
        $total = isset($data['payment_sum'])?$data['payment_sum']:0;

        

        unset($formattedData['order_type']);
      
        $order->status_id = 1;
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
