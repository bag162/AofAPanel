<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitAofaOrders5 extends Migration
{
    public function up()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->text('note')->nullable();
            $table->decimal('total', 10, 2)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_aofa_orders', function($table)
        {
            $table->dropColumn('note');
            $table->decimal('total', 10, 2)->nullable(false)->change();
        });
    }
}
