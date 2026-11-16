<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array('name' => function() {
    return GWF_User::getStaticOrGuest()->displayUsername();
}));
