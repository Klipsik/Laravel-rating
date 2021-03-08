<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('votings')) {
            Schema::create('votings', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->morphs('model');
                $table->morphs('voteable');

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
        if (Schema::hasTable('votings')) {
            Schema::drop('votings');
        }
    }
}