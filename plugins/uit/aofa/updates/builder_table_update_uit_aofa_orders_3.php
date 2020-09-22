<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitAofaOrders3 extends Migration
{
    public function up()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->integer('key_id')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->dropColumn('key_id');
        });
    }
}
