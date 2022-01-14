<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_jobs', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_maincrm_jobs');
            $table->engine = 'InnoDB';
            $table->increments('id') -> autoIncrement ();
            $table->integer('master_id');
            $table->integer('manager_id');
            $table->integer('name_id');
            $table->string('massage_id') -> nullable();
            $table->string('type_device') -> default('-');
            $table->string('brand_device') -> default('-');
            $table->string('devicemodel') -> default('-');
            $table->string('imei') -> default('-');
            $table->string('status_job') -> default('-');
            $table->string('type_guarantee_job') -> nullable();
            $table->string('guarantee') -> nullable();
            $table->string('discount') -> nullable();
            $table->string('cost') -> default(0);
            $table->string('payment_method') -> default('-');
            $table->string('descriptions') -> nullable();
            $table->string('note') -> nullable();
            $table->string('info') -> nullable();
            $table->string('type_job');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_jobs');
    }
}
