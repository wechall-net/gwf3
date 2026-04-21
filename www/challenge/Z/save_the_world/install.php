<?php
$solution = require 'solution.php';
chdir("../../");
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return;
}

$title = "Save the World";
$score = 8;
$url = "challenge/save_the_world";
$creators = "Z";


htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
