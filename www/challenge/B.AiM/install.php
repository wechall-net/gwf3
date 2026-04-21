<?php
chdir("../../");
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = "B.AiM";
$solution = false;
$score = 6;
$url = "challenge/B.AiM/index.php";
$creators = "BAIM,Gizmore";
$tags = 'Cracking,Windows,Realistic';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
