<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('code_name', 10);
            $table->unsignedBigInteger('user_id')->default(0);
            // $table->tinyInteger('printed')->default(0);
            // $table->tinyInteger('requested')->default(0);
            // $table->tinyInteger('sent')->default(0);
            $table->string('code_title', 100)->default(0);
            // $table->tinyInteger('distributed')->default(0);
            // $table->unsignedBigInteger('distributor_id')->default(0);
            // $table->unsignedBigInteger('sale_id')->default(0);
            // $table->unsignedBigInteger('promo_id')->default(0);
            // $table->date('exp_date')->nullable();
            $table->tinyInteger('geo_location')->default(0);
            $table->multiPolygon('location')->nullable();

            $table->index('user_id');
            $table->index('code_name');
            // $table->index('distributor_id');
            // $table->index('sale_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codes');
    }
}
