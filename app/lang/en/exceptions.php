<?php
return array(
  'Sentry' => array(
    'UserNotFoundException' => "User was not found.",
    'WrongPasswordException' => 'Wrong password, try again.',
    'UserNotActivatedException' => 'User is not activated.',
    'UserSuspendedException' => 'User is suspended',
    'UserBannedException' => 'User is banned',
    'UserExistsException' => 'User with this login already exists.',
    'GroupNotFoundException' => 'Group was not found.',
  ),
  'Opauth' => array(
    'callback' => 'Unsupported callback_transport.',
    'error' => 'Authentication error: Opauth returns error auth response.'
    'missing' => 'Invalid auth response: Missing key auth response components.',
    'reason'  => 'Invalid auth response: :reason',
  );
);
