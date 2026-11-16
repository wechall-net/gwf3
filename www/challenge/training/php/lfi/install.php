<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';
WCChallenge::install(__DIR__, function() {
	echo GWF_HTML::error('WeChall', 'This script would install this challenge. It`s not of interest for you.');
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	return array('skip_install' => true);
});
?>
