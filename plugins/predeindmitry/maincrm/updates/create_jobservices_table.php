<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateJobServiceTable extends Migration
{
    public function up()
    {
        Schema::create('job_service', function (Blueprint $table) {
            Schema::dropIfExists('job_service');
            $table->engine = 'InnoDB';
            $table->integer('job_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->primary(['job_id', 'service_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_service');
    }
}
