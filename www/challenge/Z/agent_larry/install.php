<?php
$solution = require 'solution.php';
chdir("../../");
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return;
}

$title = "Agent Larry";
$score = 7;
$url = "challenge/agent_larry/index.php";
$creators = "Z";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
