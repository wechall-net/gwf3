<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'challenge_after' => function() {
        return '<p>The solution is the last 20 digits of the symmetric key(m)</p>';
    },
));
