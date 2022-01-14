<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStocksTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_stocks', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_maincrm_stocks');
            $table->engine = 'InnoDB';
            $table->increments('id') -> autoIncrement ();
            $table->string('stock');
            $table->string('stock_address');
            $table->string('schedule');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_stocks');
    }
}
