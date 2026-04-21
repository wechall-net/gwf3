<?php
$solution = require 'solution.php';
chdir("../../");
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return htmlDisplayError("Admin !!");
}

$title = "The Nap";
$score = 5;
$url = "challenge/the_nap/index.php";
$creators = "Z";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
