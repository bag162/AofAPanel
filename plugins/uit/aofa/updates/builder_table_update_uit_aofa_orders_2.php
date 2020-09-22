<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitAofaOrders2 extends Migration
{
    public function up()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->decimal('total', 10, 2)->default(0.00);
        });
    }
    
    public function down()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->dropColumn('total');
        });
    }
}
