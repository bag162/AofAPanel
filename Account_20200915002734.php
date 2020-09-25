<?php namespace Uit\Aofa\Components;

use Cms\Classes\ComponentBase;

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


    public function onLogin(){
        $key = post('key', false);
        if(!$key || trim($key) == "") return ['.container_message' => $this->renderPartial('@_message',['type' => 'error', 'message' => 'Введите свой API ключ'])];
        $existsKey = Key::where('key', $key)->first();
        if(is_null($existsKey)) return ['.container_message' => $this->renderPartial('@_message', ['type' => 'error', 'message' => 'Данного API ключа нет в базе AofA'])];
        session()->put('auth_key', $key);

        return redirect()->to('dashboard');
    }
}
