<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('landing_page_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->tinyinteger('has_attribution')->default(0);
            $table->dateTime('converted_date')->nullable();
            $table->dateTime('closed_date')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('company');
            $table->string('title');
            $table->string('phone', 20);
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip', 10);
            $table->string('country');
            $table->text('custom');
            $table->foreign('landing_page_id')
                ->references('id')
                ->on('landing_pages')
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
        Schema::drop('leads');
    }
}
