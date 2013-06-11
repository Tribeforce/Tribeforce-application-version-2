<?php

class UserSeeder extends Seeder {

  public function run()
  {
    DB::table('users')->delete();
    DB::table('groups')->delete();
    DB::table('companies')->delete();
    DB::table('users_groups')->delete();

    // Create the admin group
    $group = Sentry::getGroupProvider()->create(array(
        'name'        => 'admin',
        'permissions' => array(
            'admin' => 1,
            'users' => 1,
        ),
    ));

    // Create companies
    $adforce = Company::create(array('name' => 'Adforce'));
    $tribeforce = Company::create(array('name' => 'Tribeforce'));

    // Create users belonging to the Adforce group
    $user0 = User::create(array(
      'first_name' => 'Femi',
      'last_name' => 'Veys',
      'email' => 'femiveys@gmail.com',
      'password' => '1234',
      'activated' => true,
      'type' => 0,
      'company_id' => $adforce->id,
    ));

    $user1 = User::create(array(
      'first_name' => 'User1',
      'last_name' => 'Lastname',
      'email' => 'user1@tribeforce.com',
      'password' => '1234',
      'activated' => true,
      'type' => 3,
      'company_id' => $adforce->id,
    ));

    $user2 = User::create(array(
      'first_name' => 'User2',
      'last_name' => 'Lastname',
      'email' => 'user2@tribeforce.com',
      'password' => '1234',
      'activated' => true,
      'type' => 2,
      'company_id' => $adforce->id,
    ));

    $user3 = User::create(array(
      'first_name' => 'User3',
      'last_name' => 'Lastname',
      'email' => 'user3@tribeforce.com',
      'password' => '1234',
      'activated' => true,
      'type' => 1,
      'company_id' => $adforce->id,
    ));

    $user4 = User::create(array(
      'first_name' => 'User4',
      'last_name' => 'Lastname',
      'email' => 'user4@tribeforce.com',
      'password' => '1234',
      'activated' => true,
      'type' => 0,
      'company_id' => $tribeforce->id,
    ));

    $user5 = User::create(array(
      'first_name' => 'User5',
      'last_name' => 'Lastname',
      'email' => 'user5@tribeforce.com',
      'password' => '1234',
      'activated' => true,
      'type' => 0,
      'company_id' => $tribeforce->id,
    ));

    // Add user0 to the admin group
    $user0->addGroup($group);
  }
}
