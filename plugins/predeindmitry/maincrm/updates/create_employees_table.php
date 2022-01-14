<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_employees', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_maincrm_employees');
            $table->engine = 'InnoDB';
            $table->increments('id') -> autoIncrement ();
            $table->string('name');
            $table->string('position');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_employees');
    }
}
