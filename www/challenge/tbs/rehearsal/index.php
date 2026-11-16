<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'name' => function() {
        $user = GWF_User::getStaticOrGuest();
        return $user->isGuest() ? 'hacker' : $user->displayUsername();
    },
    'downloads' => function() { return GWF_WEB_ROOT.'downloads'; },
    'youtube' => 'https://www.youtube.com/watch?v=2SZ86fI3CLU',
));
