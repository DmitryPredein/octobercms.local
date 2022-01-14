<?php namespace PredeinDmitry\CreateLanding\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLandingsTable extends Migration
{
    public function up()
    {
        Schema::create('predeindmitry_createlanding_landings', function (Blueprint $table) {
            Schema::dropIfExists('predeindmitry_createlanding_landings');
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('menu')->nullable();
            $table->string('tel')->nullable();
            $table->string('label_tel')->nullable();
            $table->string('logo')->nullable();
            $table->string('label_descriptor')->nullable();
            $table->string('label_button_descriptor')->nullable();
            $table->string('description_descriptor')->nullable();
            $table->string('img_descriptor')->nullable();
            $table->string('img_back_descriptor')->nullable();
            $table->string('img_arrow_left_slider1')->nullable();
            $table->string('img_arrow_right_slider1')->nullable();
            $table->string('item_slider1')->nullable();
            $table->string('color_back_button')->nullable();
            $table->string('color_back_secondary')->nullable();
            $table->string('color_back_primary')->nullable();
            $table->string('color_fonts_ptimary')->nullable();
            $table->string('color_fonts_secondary')->nullable();
            $table->string('color_fonts_button')->nullable();
            $table->string('img_back_maincontent')->nullable();
            $table->string('img_arrow_up')->nullable();
            $table->string('img_back_model1')->nullable();
            $table->string('img_back_model2')->nullable();
            $table->string('label_slider2')->nullable();
            $table->string('color_back_description_item_slider2')->nullable();
            $table->string('img_arrow_left_slider2')->nullable();
            $table->string('img_arrow_right_slider2')->nullable();
            $table->string('item_slider2')->nullable();
            $table->string('label_model')->nullable();
            $table->string('label_button_model')->nullable();
            $table->string('item_model')->nullable();
            $table->string('label_price')->nullable();
            $table->string('description_price')->nullable();
            $table->string('item_selectedtypedevice')->nullable();
            $table->string('price_item')->nullable();
            $table->string('item_info')->nullable();
            $table->string('label_stat')->nullable();
            $table->string('value_stat')->nullable();
            $table->string('description_stat')->nullable();
            $table->string('color_value_stat')->nullable();
            $table->string('color_back1_nuber_stat')->nullable();
            $table->string('color_back2_nuber_stat')->nullable();
            $table->string('label_homeOrder')->nullable();
            $table->string('placeholder_form_name_homeOrder')->nullable();
            $table->string('placeholder_form_tel_homeOrder')->nullable();
            $table->string('label_form_button_homeOrder')->nullable();
            $table->string('description_homeOrder')->nullable();
            $table->string('img_back_homeOrder')->nullable();
            $table->string('label_feedback')->nullable();
            $table->string('img_arrow_left_feedback')->nullable();
            $table->string('img_arrow_right_feedback')->nullable();
            $table->string('img_user_item_feedback')->nullable();
            $table->string('item_feedback')->nullable();
            $table->string('label_homeOrder2')->nullable();
            $table->string('placeholder_form_name_homeOrder2')->nullable();
            $table->string('placeholder_form_tel_homeOrder2')->nullable();
            $table->string('label_form_button_homeOrder2')->nullable();
            $table->string('description_homeOrder2')->nullable();
            $table->string('img_back_homeOrder2')->nullable();
            $table->string('label_offer')->nullable();
            $table->string('description_offer')->nullable();
            $table->string('label1_footer')->nullable();
            $table->string('label2_footer')->nullable();
            $table->string('color_back_footer')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predeindmitry_createlanding_landings');
    }
}
