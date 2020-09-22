<?php namespace Uit\Aofa\Models;

use Model;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // protected $jsonable = ['payments'];

    // A unique code
    public $settingsCode = 'uit_aofa_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    
}
