<?php namespace Uit\Aofa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitAofaKeys3 extends Migration
{
    public function up()
    {
        Schema::table('uit_aofa_keys', function($table)
        {
            $table->dateTime('tn_manager_end')->nullable();
            $table->dateTime('sms_service_end')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_aofa_keys', function($table)
        {
            $table->dropColumn('tn_manager_end');
            $table->dropColumn('sms_service_end');
        });
    }
}
