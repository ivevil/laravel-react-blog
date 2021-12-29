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
            $table->increments('id');
            $table->string('title');
            $table->longText('body');
            $table->string('featured_image');
            $table->timestamps();
            $table->unsignedInteger('userid');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('categoryid');
            $table->foreign('categoryid')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts', function (Blueprint $table) {
            $table->dropForeign('posts_userid_foreign');
            $table->dropForeign('posts_categoryid_foreign');
        });
        
    }
}
