<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('likings')) {
            Schema::create('likings', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->morphs('model');
                $table->morphs('likable');

                $table->decimal('value', 2, 1);

                $table->timestamps();
            });
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('likings')) {
            Schema::drop('likings');
        }
    }
}