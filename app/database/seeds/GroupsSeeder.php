<?php

class GroupsSeeder extends Seeder {

  public function run() {
    DB::table('groups')->delete();

    try {
      // Create the group
      $group = Sentry::getGroupProvider()->create(array(
          'name'        => 'Administrators',
          'permissions' => array(
              'admin' => 1,
              'users' => 1,
          ),
      ));
    } catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
        echo 'Name field is required';
    } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
        echo 'Group already exists';
    }
  }
}
