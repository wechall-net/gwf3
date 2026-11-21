<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'AAA');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');

if (false === ($chall = WC_Challenge::getByTitle("Anderson Application Auditing"))) {
	$chall = WC_Challenge::dummyChallenge('Anderson Application Auditing');
}
$chall->showHeader();

# Solve it
$chall->onCheckSolution();

# Mission Info
echo GWF_Box::box($chall->lang('index_info', ['index2.html']));

# Thanks
$thm = sprintf('<a href="%sprofile/TheHiveMind">TheHiveMind</a>', GWF_WEB_ROOT);
$chaos = sprintf('<a href="%sprofile/Chaosdreamer">Chaosdreamer</a>', GWF_WEB_ROOT);
echo GWF_Box::box($chall->lang('thanks', array($thm, $chaos)));

# Solve Box
formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
