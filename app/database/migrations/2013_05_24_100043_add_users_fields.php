<?php

use Illuminate\Database\Migrations\Migration;

class AddUsersFields extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function($table)
    {
      $table->binary('settings');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function($table)
    {
      $table->dropColumn('settings');
    });
  }

}
