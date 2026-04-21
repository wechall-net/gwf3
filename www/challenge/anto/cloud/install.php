<?php
$solution = require 'solution.php';
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install Cloud");
if (GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Out of the Cloud";
$score = 5;
$url = "challenge/cloud/index.php";
$creators = "anto";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
