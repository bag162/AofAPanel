<?php namespace Uit\Aofa;

use System\Classes\PluginBase;
use Uit\Aofa\Models\Settings;
use Config;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        $types =  Config::get('uit.aofa::types', []);
        $typeComponents = [];
        foreach($types as $type){
           $typeComponents["Uit\Aofa\Components\\".$type['component']] = $type['component'];
        }

        $components =  [
            'Uit\Aofa\Components\Account' => 'account',
            'Uit\Aofa\Components\OrderForm' => 'orderForm',
            'Uit\Aofa\Components\Orders' => 'orders',
            'Uit\Aofa\Components\FaqList' => 'faqList',
        ];

        return array_merge($components, $typeComponents);
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'AofA Settings',
                'description' => 'AofA settings page.',
                'category'    => 'Users',
                'icon'        => 'icon-cog',
                'class'       => 'Uit\Aofa\Models\Settings',
                'order'       => 500,
                'keywords'    => 'aofa, payments',
                // 'permissions' => ['acme.users.access_settings']
            ]
        ];
    }


    public function registerMarkupTags()
    {
        return [
            'filters' => [
                // A global function, i.e str_plural()
               // 'plural' => 'str_plural',

                // A local method, i.e $this->makeTextAllCaps()
                // 'uppercase' => [$this, 'makeTextAllCaps']
            ],
            'functions' => [
                // A static method call, i.e Form::open()
                'aofa_settings' =>[$this, 'aofaSettings'],
            ]
        ];
    }

    public function aofaSettings($key, $default=null)
    {
        $settings = Settings::instance();
        return ($settings->get($key))?$settings->get($key):$default;
    }
}
