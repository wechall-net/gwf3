<?php
$solution = require 'solution.php';
chdir('../../../');
require_once("challenge/html_head.php");
html_head("Install DropDaBass Challenge");

if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "DropDaBass";
$score = 4;
$url = "challenge/DropDaBass/index.php";
$creators = "anto";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
