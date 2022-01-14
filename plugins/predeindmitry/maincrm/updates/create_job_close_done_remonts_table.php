<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateJobCloseDoneRemontsTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_job_close_done_remonts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_job_close_done_remonts');
    }
}
