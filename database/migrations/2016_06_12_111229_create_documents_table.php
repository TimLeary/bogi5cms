<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function(Blueprint $table)
        {
            // These columns are needed for Baum's Nested Set implementation to work.
            // Column names may be changed, but they *must* all exist and be modified
            // in the model.
            // Take a look at the model scaffold comments for details.
            // We add indexes on parent_id, lft, rgt columns by default.
            $table->increments('id');
            $table->integer('parent_id')->nullable()->unsigned()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();

            $table->integer('type_taxonomy_id')->nullable()->unsigned();
            $table->integer('name_description_id')->unsigned();
            $table->integer('priority')->unsigned()->nullable();
            $table->boolean('is_active')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('name_description_id')->references('id')->on('descriptions');
            $table->foreign('type_taxonomy_id')->references('id')->on('taxonomies');
            $table->foreign('parent_id')->references('id')->on('documents');
        });

        Schema::create('document_descriptions', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('document_id')->nullable()->unsigned();
            $table->integer('type_taxonomy_id')->nullable()->unsigned();
            $table->integer('description_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('description_id')->references('id')->on('descriptions');
            $table->foreign('type_taxonomy_id')->references('id')->on('taxonomies');
            $table->foreign('document_id')->references('id')->on('documents');
        });

        Schema::create('document_languages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('document_id')->unsigned();
            $table->integer('language_id')->unsigned();

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
        Schema::table('documents', function(Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['type_taxonomy_id']);
            $table->dropForeign(['name_description_id']);
        });

        Schema::table('document_descriptions', function(Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['type_taxonomy_id']);
            $table->dropForeign(['description_id']);
        });

        Schema::table('document_languages', function(Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['language_id']);
        });

        Schema::drop('documents');
        Schema::drop('document_descriptions');
        Schema::drop('document_languages');
    }
}
