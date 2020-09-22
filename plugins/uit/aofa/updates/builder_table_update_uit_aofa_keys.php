<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitAofaKeys extends Migration
{
    public function up()
    {
        Schema::table('uit_aofa_keys', function($table)
        {
            $table->decimal('balance', 10, 2)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_aofa_keys', function($table)
        {
            $table->decimal('balance', 10, 2)->nullable(false)->change();
        });
    }
}
