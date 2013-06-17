<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserFields extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function(Blueprint $table)
    {
      $table->integer('occupation_id')->unsigned()->after('id');
      $table->text('destiny')->after('last_name');
      $table->text('character')->after('last_name');
      $table->text('calling')->after('last_name');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function(Blueprint $table)
    {
      $table->dropColumn('occupation_id');
      $table->dropColumn('destiny');
      $table->dropColumn('character');
      $table->dropColumn('calling');
    });
  }

}
