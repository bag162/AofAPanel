<?php namespace Uit\Aofa\Components;

use Cms\Classes\ComponentBase;
use Uit\Aofa\Models\Faq;

class FaqList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'FaqList Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->page['faqs'] = $this->loadFaqs();
    }


    public function loadFaqs(){
        return Faq::all();
    }
}
