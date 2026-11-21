<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'challenge_after' => function($translations, $placeholders) {
        return $placeholders['challenge_trailer'];
    },
));
