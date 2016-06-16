<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDocumentLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_links', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('document_id')->unsigned();
            $table->string('link')->unique();
            $table->integer('language_id')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_links', function(Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['language_id']);
        });

        Schema::drop('document_links');
    }
}
