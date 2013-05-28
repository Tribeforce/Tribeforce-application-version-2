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
    'error' => ':provider heeft je geen toestemming gegeven om in te loggen.',
    'missing' => 'Ongeldig auth antwoord: Delen van key auth antwoord ontbreken.',
    'reason'  => 'Ongeldig auth antwoord: :reason.',
    'not_found' => "Sorry, maar deze :provider account is niet gelinkt met ons.",
  ),
  'Symfony' => array(
    'AccessDeniedHttpException' => "Je hebt geen toegang.",
    'NotFoundHttpException'     => "Deze pagina kon niet worden gevonden.",
  ),
  'not_logged_in' => 'Je moet ingelogd zijn om deze pagina te bezoeken.',
);
