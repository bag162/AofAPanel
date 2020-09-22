<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitAofaOrders4 extends Migration
{
    public function up()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->string('key')->nullable();
            $table->dropColumn('key_id');
        });
    }
    
    public function down()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->dropColumn('key');
            $table->integer('key_id')->nullable()->unsigned();
        });
    }
}
