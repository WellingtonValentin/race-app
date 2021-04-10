<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunnerCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runner_competitions', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('runner_id')->unsigned();
            $table->foreign('runner_id')
                ->references('id')
                ->on('runners')
                ->onDelete('cascade');
            $table->bigInteger('competition_id')->unsigned();
            $table->foreign('competition_id')
                ->references('id')
                ->on('competitions')
                ->onDelete('cascade');

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
        Schema::dropIfExists('runner_competitions');
    }
}
