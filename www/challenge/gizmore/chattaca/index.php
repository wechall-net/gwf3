<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array('name' => function() {
    $user = GWF_User::getStaticOrGuest();
    return $user->isGuest() ? 'hacker' : $user->displayUsername();
}));
