<?php
$solution = require 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
html_head("Install Enlightment");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Enlightment";
$score = 2;
$url = "challenge/enlightment/index.php";
$creators = "anto";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
