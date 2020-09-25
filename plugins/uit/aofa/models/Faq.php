<?php namespace Uit\Aofa\Models;

use Model;

/**
 * Model
 */
class Faq extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_aofa_faqs';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
