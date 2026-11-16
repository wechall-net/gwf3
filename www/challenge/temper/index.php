<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'name' => function() { return GWF_User::getStaticOrGuest()->displayUsername(); },
));
