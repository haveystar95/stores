<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParesersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parsers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('link_id');
            $table->integer('level');
            $table->text('pattern');
            $table->string('property');
            $table->string('field_next')->nullable();
            $table->string('field')->nullable();
            $table->boolean('is_body_content')->default(false);
            $table->boolean('look_at_main')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paresers');
    }
}
