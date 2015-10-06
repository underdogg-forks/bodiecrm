<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersToLandingPagesEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_to_landing_page_email', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('landing_page_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->unique(['landing_page_id', 'user_id']);

            $table->foreign('landing_page_id')
                ->references('id')
                ->on('landing_pages');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_to_landing_page_email');
    }
}
