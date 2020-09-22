<?php namespace Uit\Aofa\Components;

use Cms\Classes\ComponentBase;
use Uit\Aofa\Models\Order;

class Orders extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Orders Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->page['orders'] = $this->loadOrders();
    }


    public function loadOrders(){
        return Order::where('key', $this->getKey())->orderBy('created_at','desc')->paginate(5);
    }


    public function getKey(){
        return session()->get('auth_key');
    }
}
