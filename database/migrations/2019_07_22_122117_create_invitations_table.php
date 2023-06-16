<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_user_id')->unsigned();
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('to_user_id')->unsigned();
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('course_id')->unsigned()->nullable()->default(null);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
            $table->mediumText('additional_data');
            $table->string('type')->default("");
            $table->string('status')->default("");
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
        Schema::dropIfExists('invitations');
    }
}
