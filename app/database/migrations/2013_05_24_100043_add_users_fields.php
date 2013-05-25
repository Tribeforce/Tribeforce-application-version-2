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
      $table->binary('settings')->after('last_name');
      $table->integer('facebook_id')->unique()->unsigned()->after('email');
      $table->integer('linkedin_id')->unique()->unsigned()->after('email');
      $table->integer('google_id')->unique()->unsigned()->after('email');
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
      $table->dropColumn('facebook_id');
      $table->dropColumn('linkedin_id');
      $table->dropColumn('google_id');
    });
  }

}
