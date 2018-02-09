<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRankToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Added a rank column to users table, to signify free or paid user
        Schema::table('users', function($table){
            $table->integer('rank')->after('id');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Removes the rank column from the users table
        Schema::table('users', function($table){
            $table->dropColumn('rank');
        });
    }
}
