<?php
chdir('../../../');
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin!");
}

$title = "Prime Factory";
$solution = require 'solution.php';
$score = 1;
$url = "challenge/training/prime_factory/index.php";
$creators = "ch0wch0w";
$tags = 'Training,Math';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags);

require_once("challenge/html_foot.php");
?>
