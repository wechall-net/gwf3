<?php
$solution = require 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = "The Last Hope";
$score = 5;
$url = "challenge/bsdhell/thelasthope/index.php";
$creators = "bsdhell";
$tags = 'Linux,Cracking';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
