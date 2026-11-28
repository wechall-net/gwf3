<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install Order By Query");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Order By Query";
$solution = require_once __DIR__.'/solution.php';
$score = 7;
$url = "challenge/order_by_query/index.php";
$creators = "Gizmore";
$tags = 'Exploit,PHP,MySQL,Realistic';

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>
