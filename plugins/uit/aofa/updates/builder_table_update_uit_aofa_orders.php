<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitAofaOrders extends Migration
{
    public function up()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->integer('status_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->dropColumn('status_id');
        });
    }
}
