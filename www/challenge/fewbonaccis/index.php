<?php
require_once dirname(__DIR__).'/WCChallenge.php';

apache_setenv('no-gzip', 1);
ini_set('zlib.output_compression', 'Off');
while (ob_get_level() > 0) { ob_end_clean(); }

WCChallenge::run(__DIR__, array(
	'name' => function() {
		$user = GWF_User::getStaticOrGuest();
		return htmlspecialchars($user->isGuest() ? 'hacker' : $user->displayUsername(), ENT_QUOTES, 'UTF-8');
	},
), array(
	'request' => function($chall) {
		if (!isset($_POST['try'])) {
			return null;
		}
		require __DIR__.'/try.php';
		return trying() ? true : false;
	},
	'render' => function() {
		$ip = $_SERVER['REMOTE_ADDR'];
		$ip = GWF_IP6::isV6($ip) ? "[{$ip}]" : $ip;
		$host = isset($_POST['host']) ? $_POST['host'] : sprintf('http://%s/fib.php?n=', $ip);
		return '<form method="post" action="?">'.PHP_EOL.
			'<input type="text" name="host" value="'.htmlspecialchars($host, ENT_QUOTES, 'UTF-8').'" size="32" />'.PHP_EOL.
			'<input type="submit" name="try" value="TRY MICROSERVICE" />'.PHP_EOL.
			'</form>'.PHP_EOL;
	},
));
