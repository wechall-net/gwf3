<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'hintlink' => function() {
        $chall = WC_Challenge::getByTitle('Brainfucked');
        $hint = $chall === false ? 'source code' : WCChallenge::trans($chall, 'hint');
        return '<a href="index.php?highlight=source">'.$hint.'</a>';
    },
));
