<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateJobStocksTable extends Migration
{
    public function up()
    {
        Schema::create('job_stock', function (Blueprint $table) {
            Schema::dropIfExists('job_stock');
            $table->engine = 'InnoDB';
            $table->integer('job_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->primary(['job_id', 'stock_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_stock');
    }
}
