<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install Hanoi");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Towers of Hanoi";
$solution = false;
$score = 3;
$url = "challenge/hanoi/index.php";
$creators = "Z";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>