<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title', 100);
            $table->text('description');
        });
    }

    //php artisan make:migration modify_posts_table
    //php artisan migrate


    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
