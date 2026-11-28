<?php
require_once __DIR__.'/secrets.php';
require_once __DIR__.'gbook.include';

chdir('../../');
define('GWF_PAGE_TITLE', 'The Guestbook');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, '/challenge/guestbook/index.php', false);
}
$chall->showHeader();

$chall->onCheckSolution();


htmlTitleBox($chall->lang('title'), $chall->lang('info', array('gbook.include', 'index.php?highlight=christmas')));

if (false !== Common::getPost('sign')) {
	gbook_insertMessage(0, Common::getPost('message', ''));
}
elseif (false !== Common::getPost('clear')) {
	gbook_clear();
}
elseif (Common::getGet('highlight') === 'christmas')
{
	$msg = file_get_contents('challenge/guestbook/gbook.include');
	$msg = '[code=php title=gbook.php.inc]'.$msg.'[/code]';
	echo GWF_Box::box(GWF_Message::display($msg, true, false, false));
}


echo GWF_Box::box(gbook_display());

echo GWF_Box::box(gbook_form());

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
