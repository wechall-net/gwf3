<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Hi');
require_once("challenge/html_head.php");
require_once(GWF_CORE_PATH.'module/WeChall/solutionbox.php');

if (false === ($chall = WC_Challenge::getByTitle('Hi'))) {
	$chall = WC_Challenge::dummyChallenge('Hi');
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box($chall->lang('info'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
