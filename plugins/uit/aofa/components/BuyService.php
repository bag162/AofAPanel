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
                    $attributes[$field['name']] = $field['label'];
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
   
        $total = $data['payment_sum'];

        

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
                'message' => 'Ваш запрос успешно отправлен',
            ]),
        ];
    }

 
}