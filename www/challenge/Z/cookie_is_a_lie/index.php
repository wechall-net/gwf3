<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'The cookie is a lie');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle("The Cookie is a lie"))) {
	$chall = WC_Challenge::dummyChallenge("[The Cookie is a lie]");
}
$chall->showHeader();
echo GWF_Box::box($chall->lang('index_info', array('http://mainframe.cake/experience.php', 'experience.php_txt', 'steal_cookie.php_txt', GWF_WEB_ROOT.'pm/send/to/Z')));
$chall->onCheckSolution();
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once 'challenge/html_foot.php';
?>

