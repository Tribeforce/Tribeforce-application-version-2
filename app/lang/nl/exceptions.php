<?php
return array(
  'Sentry' => array(
    'UserNotFoundException' => "Deze gebruiker bestaat niet.",
    'WrongPasswordException' => 'Verkeerd paswoord, probeer opnieuw.',
    'UserNotActivatedException' => 'Deze gebruiker is niet geactiveerd.',
    'UserSuspendedException' => 'Deze gebruiker is geschorst.',
    'UserBannedException' => 'Deze gebruiker is verbannen.',
    'UserExistsException' => 'Een gebruiker met deze login bestaat reeds.',
    'GroupNotFoundException' => 'De group bestaat niet.',
  ),
  'Opauth' => array(
    'callback' => 'callback_transport wordt niet ondersteund.',
    'error' => 'Authentificatie fout: Opauth geeft error auth response.',
    'missing' => 'Ongeldig auth antwoord: Delen van key auth antwoord ontbreken.',
    'reason'  => 'Ongeldig auth antwoord: :reason',
  );
);
