<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'name' => function() {
        $user = GWF_User::getStaticOrGuest();
        return $user->isGuest() ? 'hacker' : $user->displayUsername();
    },
    'n' => function() {
        $values = require __DIR__.'/solution.php';
        return $values[0];
    },
));
