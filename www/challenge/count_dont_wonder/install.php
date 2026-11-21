<?php
$solution = require 'solution.php';
chdir("../../");
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return htmlDisplayError("You need to be admin");
}

$title = "Count, don't wonder";

$score = 6;
$url = "challenge/count_dont_wonder";
$creators = "galen";


htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
