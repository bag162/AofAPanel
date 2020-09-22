<?php  namespace Uit\Aofa\Classes;

use Uit\Aofa\Models\Key;

trait ServiceTrait {
    public function getKey(){
        return session()->get('auth_key');
    }

    public function getBalance(){
        $key = Key::where('key', $this->getKey())->first();
        return $key->balance;
    }
}