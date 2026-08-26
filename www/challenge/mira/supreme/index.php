<?php
$secret = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "Supreme");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/mira/supreme/index.php', $secret);
}

$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$link = "https://backend.www.linkuup.de/user.profile.for.shqiprim.html";
$info = $chall->lang('info', array($user->displayUsername(), $link));
$title = $chall->lang('title');

echo GWF_Box::box($info, $title);

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
