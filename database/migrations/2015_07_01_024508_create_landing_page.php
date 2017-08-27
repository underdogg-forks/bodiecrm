<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->string('title', 100);
            $table->string('auth_key', 40);
            $table->text('return_url');
            $table->text('description');
            $table->boolean('active')->default(1);
            $table->boolean('send_email')->default(0);
            $table->string('email_title', 500);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('campaign_id')
                ->references('id')
                ->on('campaigns')
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
        Schema::drop('landing_pages');
    }
}
