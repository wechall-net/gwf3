<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'name' => function() { return GWF_User::getStaticOrGuest()->displayUsername(); },
    'login' => 'site/login.php',
    'github' => 'https://github.com/wechall-net/gwf3/tree/master/www/challenge/temper',
));
