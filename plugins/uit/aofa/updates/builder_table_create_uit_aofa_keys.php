<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitAofaKeys extends Migration
{
    public function up()
    {
        Schema::create('uit_aofa_keys', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('key');
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_aofa_keys');
    }
}
