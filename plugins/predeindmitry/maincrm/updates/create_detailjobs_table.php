<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDetailJobsTable extends Migration
{
    public function up()
    {
        Schema::create('detail_job', function (Blueprint $table) {
            Schema::dropIfExists('detail_job');
            $table->engine = 'InnoDB';
            $table->integer('job_id')->unsigned();
            $table->integer('detail_id')->unsigned();
            $table->primary(['job_id', 'detail_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_job');
    }
}
