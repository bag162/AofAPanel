<?php namespace Uit\Aofa\Components;

use Cms\Classes\ComponentBase;
use Uit\Aofa\Models\Key;
use Lang;

class Account extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Account Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $auth_key = session()->get('auth_key');
        $this->page['api_key'] = Key::where('key', $auth_key)->first();
    }


    public function onLogin(){
        $key = post('key', false); //Введите свой API ключ
        if(!$key || trim($key) == "") return ['.container_message' => $this->renderPartial('@_message',['type' => 'error', 'message' => Lang::get('uit.aofa::lang.message.enter_api_key')])];
        $existsKey = Key::where('key', $key)->first(); //'Данного API ключа нет в базе AofA'
        if(is_null($existsKey)) return ['.container_message' => $this->renderPartial('@_message', ['type' => 'error', 'message' => Lang::get('uit.aofa::lang.message.api_key_notexits') ])];
        
        if(!$existsKey->isActive()) return redirect()->to('locked');
        
        session()->put('auth_key', $key);

        return redirect()->to('dashboard');
    }


   
}
