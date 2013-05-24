<?php
/**
 * Opauth basic configuration file to quickly get you started
 * ==========================================================
 * To use: rename to opauth.conf.php and tweak as you like
 * If you require advanced configuration options, refer to opauth.conf.php.advanced
 */

$config = array(
/**
 * Path where Opauth is accessed.
 *  - Begins and ends with /
 *  - eg. if Opauth is reached via http://example.org/auth/, path is '/auth/'
 *  - if Opauth is reached via http://auth.example.org/, path is '/'
 */
	'path' => '/',

/**
 * Callback URL: redirected to after authentication, successful or otherwise
 */
	'callback_url' => '{path}done',

/**
 * Callback transport, for sending of $auth response
 *
 * 'session': Default. Works best unless callback_url is on a different domain than Opauth
 * 'post'   : Works cross-domain, but relies on availability of client-side JavaScript.
 * 'get'    : Works cross-domain, but may be limited or corrupted by browser URL length limit
 *            (eg. IE8/IE9 has 2083-char limit)
 */
	//'callback_transport' => 'session',

/**
 * A random string used for signing of $auth response.
 */
	'security_salt' => '123LDFmiilYf8Fyw5W10rx4W1KsVrieQCnpBzzpTBWA5vJidQKDx8pMJbmw28R1C4m',

/**
 * Strategy
 * Refer to individual strategy's documentation on configuration requirements.
 *
 * eg.
 * 'Strategy' => array(
 *
 *   'Facebook' => array(
 *      'app_id' => 'APP ID',
 *      'app_secret' => 'APP_SECRET'
 *    ),
 *
 * )
 *
 */
	'Strategy' => array(
		// Define strategies and their respective configs here
    'Facebook' => array(
        'app_id' => '536085989791390',
        'app_secret' => '834e31da9bc246713a79b91483f1dddd'
    ),

	),
);
