<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMessageLogsTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_message_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_custoners');
            $table->string('message');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_message_logs');
    }
}
