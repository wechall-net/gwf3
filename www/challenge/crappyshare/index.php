<?php
require_once dirname(__DIR__, 1).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'source' => 'crappyshare.php',
), array(
    'challenge_after' => function() {
        if (Common::getGetString('show') !== 'code') { return ''; }
        return GWF_Box::box(WCChallenge::sourceCode(__DIR__.'/crappyshare.php', 'php', 'crappyshare.php'));
    },
));
