<?php namespace Uit\Aofa\Models;

use Model;

/**
 * Model
 */
class Faq extends Model
{
    use \October\Rain\Database\Traits\Validation;
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_aofa_faqs';


    public $translatable = ['question','answer'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
