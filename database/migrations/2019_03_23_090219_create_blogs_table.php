<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('blogs', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->string('title');
         $table->string('slug');
         $table->longText('description');
         $table->string('category');
         $table->string('file_path');
         $table->tinyInteger('status');
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
      Schema::dropIfExists('blogs');
   }
}
