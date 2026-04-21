<?php
$solution = require 'solution.php';
chdir("../../../");
define('GWF_PAGE_TITLE', 'Simply Red');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle("Simply Red"))) {
	$chall = WC_Challenge::dummyChallenge("[Simply Red]", 3, "/challenge/simply_red/index.php", $solution);
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box($chall->lang('info'));
echo '<div style="margin: 10px 20px;">';
echo $chall->lang('info2', array('op.png'));
echo '</div>';
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
