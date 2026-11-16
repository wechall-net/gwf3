<?php
if (isset($_GET['show']) && $_GET['show'] === 'source') {
    header('Content-Type: text/plain');
    die(file_get_contents(__DIR__.'/globals.php'));
}
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'challenge_after' => function() {
        if (Common::getGetString('highlight') !== 'christmas') { return ''; }
        return GWF_Box::box(WCChallenge::sourceCode(__DIR__.'/globals.php', 'php', 'globals.php'));
    },
));
