<?php namespace PredeinDmitry\MasterStat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStatsTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_masterstat_stats', function (Blueprint $table) {
            
            Schema::dropIfExists('predeindmitry_masterstat_stats');
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('master_id');
            $table->integer('percent');
            $table->integer('done_device')->default(0);
            $table->bigInteger('done_cost')->default(0);
            $table->integer('return_device')->default(0);
            $table->bigInteger('return_cost')->default(0);
            $table->bigInteger('money_penalty')->default(0);
            $table->bigInteger('outcome')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('closed_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_masterstat_stats');
    }
}
