<?php
$secret = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "ChATTACA");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/gizmore/chattaca/index.php', $secret);
}

$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$url = 'https://mira-gpt.org';
$telegramURL = 'https://t.me/@gdo_dog_bot';
$discordURL = 'https://discord.gg/vjEP2yPVg';
$ircURL = 'ircs://mogwai.mira-gpt.org:6697/#dog';
$webURL = 'https://mogwai.mira-gpt.org/websocket.raw.html';

$info = $chall->lang('info', array($name, $url, $telegramURL, $discordURL, $ircURL, $webURL));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
