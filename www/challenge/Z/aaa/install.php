<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("[WeChall] Install Challenge AAA");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("You need to be admin");;
}

$title = "Anderson Application Auditing";
$solution = require 'solution.php';
$score = 6;
$url = "challenge/aaa";
$creators = "Z";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
