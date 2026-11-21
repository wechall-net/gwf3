<?php
$solution = require 'solution.php';
chdir("../../../");
define('GWF_PAGE_TITLE', 'Stegano Woman');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle("Stegano Woman"))) {
	$chall = WC_Challenge::dummyChallenge('Stegano Woman', 3, true, $solution);
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box($chall->lang('info', array('stegano_woman.zip')));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
