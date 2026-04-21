<?php
chdir('../../'); # chroot to web root
define('GWF_PAGE_TITLE', 'B.AiM'); # Wrapper hack
require_once('challenge/html_head.php'); # output start of website
# Get the challenge
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 7, 'challenge/B.AiM/index.php');
}
# And display the header
$chall->showHeader();

require_once 'challenge/B.AiM/baim_solve_form.php';

$module = Module_WeChall::instance();
$forms = new WC_BaimForms($chall);
$form = $forms->getFormAdmin($module);

if (isset($_POST['btn']))
{
	if (false !== ($error = $form->validate($module))) {
		echo $error;
	}
	else {
		$forms->executeFormAdmin($module);
	}
}

echo $form->templateY($chall->lang('form_title'));

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php'); # output start of website
?>