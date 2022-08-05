<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic', function (Blueprint $table) {
            $table->id();
            $table->integer("users_count");
            $table->integer("posts_count");
            $table->integer("latest_user_id");
            $table->string("latest_user_email");
            $table->string("latest_user_created_at");
            $table->string("latest_post_title");
            $table->integer("latest_post_id");
            $table->string("latest_post_created_at");
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
        Schema::dropIfExists('statistic');
    }
}
