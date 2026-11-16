<?php
$solution = require __DIR__.'/solution.php';
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
), array(
    'challenge_after' => function($translations) {
        return GWF_Box::box($translations['cheatsheet_html'], $translations['subtitle']);
    },
    'check' => function($answer) use ($solution) {
        for ($i = 0; $i < 56154; $i++) {
            $answer = sha1($answer);
        }
        return strcasecmp($answer, $solution) === 0;
    },
));
