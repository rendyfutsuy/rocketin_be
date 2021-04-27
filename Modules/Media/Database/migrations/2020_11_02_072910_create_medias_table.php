<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('wp_media_id')->nullable();
            $table->text('source_url')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('media_type')->nullable();
            $table->text('caption')->nullable();
            $table->text('alt_text')->nullable();
            $table->json('meta')->nullable();
            $table->json('media_detail')->nullable();
            $table->integer('is_featured')->default(0);
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
        Schema::dropIfExists('medias');
    }
}
