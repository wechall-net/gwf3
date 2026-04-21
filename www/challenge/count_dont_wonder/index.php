<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Count, don\'t wonder');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle("Count, don't wonder"))) {
	$chall = WC_Challenge::dummyChallenge("Count, don't wonder");
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box('<img src="bytes.jpg" alt="bytes.jpg" title="bytes.jpg" />');
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>