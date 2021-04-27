<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('votes')->unsigned()->default(0)->nullable();
            $table->integer('duration')->unsigned()->default(0)->nullable();
            $table->text('artist')->nullable();
            $table->text('genre')->nullable();
            $table->text('watch_url')->nullable();
            $table->integer('views')->unsigned()->default(0)->nullable();
            $table->integer('likes')->unsigned()->default(0)->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('videos');
    }
}
