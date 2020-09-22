<?php namespace Uit\Aofa\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class OrderTypes extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Uit.Aofa', 'main-menu-item2', 'side-menu-item2');
    }
}
