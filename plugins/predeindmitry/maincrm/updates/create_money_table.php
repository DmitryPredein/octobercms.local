<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMoneyTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_money', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('replenishment');
            $table->integer('expenses');
            $table->integer('salary');
            $table->string('add_money');
            $table->string('status_admission');
            $table->string('cashbox_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_money');
    }
}
