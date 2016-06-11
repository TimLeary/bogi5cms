<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('taxonomy_id')->unsigned();
            $table->string('iso_code', 255)->unique();
            $table->boolean('is_default')->default(0);
            
            $table->timestamps();
            $table->softdeletes();
        });
        
        Schema::table('languages', function(Blueprint $table)
        {
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages', function(Blueprint $table)
        {
            $table->dropForeign(['taxonomy_id']);
        });
        
        Schema::drop('languages');
    }
}
