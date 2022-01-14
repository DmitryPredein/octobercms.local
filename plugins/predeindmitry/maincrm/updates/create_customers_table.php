<?php namespace PredeinDmitry\MainCRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_maincrm_customers', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_maincrm_customers');
            $table->engine = 'InnoDB';
            $table->increments('id') -> autoIncrement ();
            $table->string('name');
            $table->string('tel');
            $table->string('address') -> nullable();
            $table->string('mail') -> nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_maincrm_customers');
    }
}
