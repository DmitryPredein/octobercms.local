<?php namespace PredeinDmitry\Cashbox\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCashboxHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_cashbox_cashbox_histories', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_cashbox_cashbox_histories');
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('user', 100);
            $table->text('komment');
            $table->bigInteger('nal')->nullable();
            $table->bigInteger('beznal')->nullable();
            $table->bigInteger('return_nal')->nullable();
            $table->bigInteger('return_beznal')->nullable();
            $table->bigInteger('expenses')->nullable();
            $table->string('stock');
            $table->dateTime('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_cashbox_cashbox_histories');
    }
}
