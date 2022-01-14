<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_details', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_maincrm_details');
            $table->engine = 'InnoDB';
            $table->increments('id') -> autoIncrement ();
            $table->string('detail_name');
            $table->string('detail_cost');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_details');
    }
}
