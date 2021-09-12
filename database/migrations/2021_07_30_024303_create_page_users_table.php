<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->default(0);
            /*$table->unsignedBigInteger('security_profiles_id'); removed 20200306*/
            /*added 20200306*/
            $table->unsignedBigInteger('page_id')->default(0);
            $table->smallInteger('permissions');
            $table->unsignedBigInteger('invitee_id')->default(0);
            /*$table->unsignedBigInteger('invitee_id')->default(0);*/
            /*removed 20200606*/
            /*added 20200606*/
            $table->char('user_type', 3)->default('spu');

            $table->index('user_id');
            /*$table->index('security_profile_id');*/
            $table->index('page_id');
            $table->index('invitee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_users');
    }
}
