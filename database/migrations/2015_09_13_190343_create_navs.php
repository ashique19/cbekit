<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->tinyInteger('type')->default(1);    // 1=level-1, 2=level-2, 3=level-3 .....
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('navs')->onDelete('set null');
            $table->string('route', 100);
            $table->string('icon', 50)->default('fa fa-tags');
            $table->tinyInteger('location')->default(1);    // 1=left, 2=top
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
        Schema::dropIfExists('navs');
    }
}
