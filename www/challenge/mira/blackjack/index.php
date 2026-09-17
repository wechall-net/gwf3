<?php
$secret = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "BlackJack");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/mira/blackjack/index.php', false);
}

$user = GWF_User::getStaticOrGuest();

$chall->showHeader();

if (isset($_POST['answer'])) {
    if (false !== ($error = $chall->isAnswerBlocked(GWF_User::getStaticOrGuest()))) {
        echo $error;
    } else {
        $answer = (string) $_POST['answer'];
        list($uname, $hash, $rich) = explode('!', $answer);
        $solution = md5($secret.md5($uname).$secret);
        $solution = substr($solution, 1, 16);
        if ($hash === $solution) {
            echo GWF_HTML::message($chall->lang('title'), $chall->lang('sucess_msg'));
            $chall->onChallengeSolved();
        } else {
            echo GWF_HTML::error($chall->lang('title'), $chall->lang('err_wrong'));
        }
    }
}

$link = "https://mogwai.mira-gpt.org"; # https://github.com/gizmore/pygdo-blackjack
$info = $chall->lang('info', array($user->displayUsername(), $link));
$title = $chall->lang('title');

echo GWF_Box::box($info, $title);

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
