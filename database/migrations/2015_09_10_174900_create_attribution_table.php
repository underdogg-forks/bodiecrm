<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribution', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('landing_page_id')->unsigned();
            $table->integer('lead_id')->unsigned();
            $table->string('email');
            $table->bigInteger('tracking_id')->nullable();
            $table->string('converting_source', 100)->nullable();
            $table->string('converting_medium', 100)->nullable();
            $table->string('converting_keyword', 100)->nullable();
            $table->string('converting_content', 100)->nullable();
            $table->string('converting_campaign')->nullable();
            $table->text('converting_landing_page')->nullable();
            $table->dateTime('converting_timestamp')->nullable();
            $table->string('original_source', 100)->nullable();
            $table->string('original_medium', 100)->nullable();
            $table->string('original_keyword', 100)->nullable();
            $table->string('original_content', 100)->nullable();
            $table->string('original_campaign')->nullable();
            $table->text('original_landing_page')->nullable();
            $table->dateTime('original_timestamp')->nullable();
            $table->text('refer_url')->nullable();
            $table->string('platform')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('version')->nullable();
            $table->foreign('landing_page_id')
                ->references('id')
                ->on('landing_pages')
                ->onDelete('cascade');

            /*
            $table->foreign('lead_id')
                ->references('id')
                ->on('leads')
                ->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attribution');
    }
}
