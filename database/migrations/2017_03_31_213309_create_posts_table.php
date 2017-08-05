<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('team_id');
            $table->longText('journal_nutrition')->nullable();
            $table->longText('journal_exercise')->nullable();
            $table->longText('journal_bible_study')->nullable();
            $table->integer('water');
            $table->integer('grain');
            $table->integer('sugar');
            $table->integer('workout');
            $table->integer('bible_study');
            $table->integer('points');
            $table->string('submit_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
