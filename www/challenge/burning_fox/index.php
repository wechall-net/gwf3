<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'challenge_after' => function($translations) {
        return GWF_Box::box($translations['challenge_trailer_html'], $translations['disc_title']);
    },
));
