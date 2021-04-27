<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('wp_post_id')->nullable();
            $table->text('title')->nullable();
            $table->text('wp_url')->nullable();
            $table->text('slug')->nullable();
            $table->longText('content')->nullable();
            $table->json('raw_content')->nullable();
            $table->text('author')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('comment_status')->nullable();
            $table->text('format')->nullable();
            $table->bigInteger('featured_media')->nullable();
            $table->text('template')->nullable();
            $table->json('meta')->nullable();
            $table->text('status')->nullable();
            $table->json('categories')->nullable();
            $table->json('tags')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
