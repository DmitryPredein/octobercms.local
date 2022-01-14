<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_services', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_maincrm_services');
            $table->engine = 'InnoDB';
            $table->increments('id') -> autoIncrement ();
            $table->string('service_name');
            $table->string('service_model');
            $table->string('service_cost') -> nullable();
            $table->string('service_time') -> nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_services');
    }
}
