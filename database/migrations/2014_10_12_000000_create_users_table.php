<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 30)->default("");
            $table->string('email')->default("");
            $table->string('password', 60)->default("");
            $table->tinyInteger('role');
            $table->string('firstname', 50)->default("");
            $table->string('lastname', 50)->default("");
            $table->string('name', 60)->default("");
            $table->string('contact', 20)->default("");
            $table->string('address', 50)->default("");
            $table->string('city', 30)->default("");
            $table->string('state', 30)->default("");
            $table->string('postcode', 10)->default("");
            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->string('parmanent_address')->default("");
            $table->tinyInteger('active')->default('1');    // 1=active; 0=inactive; 3=waiting for email verification; 4=activation pending;
            $table->integer('referrer_id')->unsigned()->nullable();
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('referral_balance')->unsigned()->default(0);
            $table->timestamp('referral_benefit_expiry_date');
            $table->string('institute_name')->default("");
            // $table->integer('institute_id')->unsigned()->nullable()->default(null);
            // $table->foreign('institute_id')->references('id')->on('users')->onDelete('set null');
            $table->string('user_photo')->default("");
            $table->decimal('balance', 10, 2)->default(0);
            $table->timestamp('expiry_date')->nullable();
            $table->integer('social_id')->unsigned()->nullable()->default(1);
            $table->foreign('social_id')->references('id')->on('socials')->onDelete('set null');
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
