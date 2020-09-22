<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitAofaKeys2 extends Migration
{
    public function up()
    {
        Schema::table('uit_aofa_keys', function($table)
        {
            $table->integer('status')->nullable()->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('uit_aofa_keys', function($table)
        {
            $table->dropColumn('status');
        });
    }
}
