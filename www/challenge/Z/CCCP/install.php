<?php
$solution = require 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
html_head("Install Credit Card Challenge Pwned!");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Credit Card Challenge Pwned!";
$score = 6;
$url = "challenge/Z/CCCP/index.php";
$creators = "Z";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
