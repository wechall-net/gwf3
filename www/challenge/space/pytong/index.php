<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'challenge_after' => function() {
        if (Common::getGetString('highlight') !== 'christmas') { return ''; }
        return WCChallenge::sourceCode(__DIR__.'/pytong.py', 'python', 'pytong.py');
    },
));
