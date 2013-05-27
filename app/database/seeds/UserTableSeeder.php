<?php

class UserTableSeeder extends Seeder {

  public function run()
  {
    DB::table('users')->delete();

    User::create(array(
      'email' => 'femiveys@gmail.com',
      'password' => Hash::make('1234'),
//      'groups' => array('Administrators'),
      'activated' => true,
    ));
  }
}
