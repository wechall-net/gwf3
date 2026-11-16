<?php
if (isset($_GET['show'])) {
    header('Content-Type: text/plain');
    die(file_get_contents(__DIR__.'/challenge.php'));
}
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'challenge_after' => function() {
        if (Common::getGetString('highlight') !== 'christmas') {
            return '';
        }
        return WCChallenge::sourceCode(__DIR__.'/challenge.php', 'php', 'challenge.php');
    },
));
