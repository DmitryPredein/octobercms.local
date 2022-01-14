<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDevicemodelsTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_devicemodels', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_maincrm_devicemodels');
            $table->engine = 'InnoDB';
            $table->increments('id') -> autoIncrement ();
            $table->string('type_device');
            $table->string('brand_device');
            $table->string('devicemodel');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_devicemodels');
    }
}
