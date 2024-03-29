<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbacks extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('feedbacks', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('feedback');
      $table->integer('source_id')->unsigned();
      $table->string('source_type');
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
    Schema::drop('feedbacks');
  }

}
