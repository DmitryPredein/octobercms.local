<?php namespace PredeinDmitry\Cashbox\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCashboxAxmobisTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_cashbox_cashbox_axmobis', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_cashbox_cashbox_axmobis');
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->bigInteger('cahs')->default(0);
            $table->bigInteger('nal')->default(0);
            $table->bigInteger('beznal')->default(0);
            $table->string('stock');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_cashbox_cashbox_axmobis');
    }
}
