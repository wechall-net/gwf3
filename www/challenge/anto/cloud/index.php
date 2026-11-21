<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Out of the Cloud');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';

if (false === ($chall = WC_Challenge::getByTitle("Out of the Cloud"))) {
	$chall = WC_Challenge::dummyChallenge("[Out of the Cloud]");
}
$chall->showHeader();

$chall->onCheckSolution();

echo GWF_Box::box($chall->lang('info', array('cloud.zip')));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once("challenge/html_foot.php");
?>