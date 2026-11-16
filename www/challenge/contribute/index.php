<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'username' => function() { return GWF_User::getStaticOrGuest()->displayUsername(); },
), array(
    'challenge_after' => function() {
        return "\n<!-- https://www.youtube.com/watch?v=DfN_ZMmiLQw -->\n";
    },
));
