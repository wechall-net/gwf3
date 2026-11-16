<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'name1' => function() {
        $user = GWF_User::getStaticOrGuest();
        return $user->isGuest() ? 'tehron' : $user->displayUsername();
    },
    'name2' => function() {
        $user = GWF_User::getStaticOrGuest();
        return $user->isGuest() ? 'hacker' : $user->displayUsername();
    },
));
