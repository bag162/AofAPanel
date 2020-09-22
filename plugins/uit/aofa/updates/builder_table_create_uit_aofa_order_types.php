<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitAofaOrderTypes extends Migration
{
    public function up()
    {
        Schema::create('uit_aofa_order_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->text('form')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_aofa_order_types');
    }
}
