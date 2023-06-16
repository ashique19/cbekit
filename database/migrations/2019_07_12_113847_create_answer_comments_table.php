<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('commented_by')->unsigned();
            $table->foreign('commented_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('attempt_id')->unsigned();
            $table->foreign('attempt_id')->references('id')->on('attempts')->onDelete('cascade');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->unsignedBigInteger('answer_comment_id')->unsigned()->nullable()->default(null);
            $table->foreign('answer_comment_id')->references('id')->on('answer_comments')->onDelete('cascade');
            $table->tinyInteger('is_reply')->default(0);
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
        Schema::dropIfExists('answer_comments');
    }
}
