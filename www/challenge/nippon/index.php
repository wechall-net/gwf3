<?php
$signs = require __DIR__.'/signs.php';
$solution = require __DIR__.'/solution.php';
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'signs' => $signs,
), array(
    'check' => function($answer) use ($solution) {
        for ($i = 0; $i < 3; $i++) {
            $answer = sha1($answer);
        }
        return strcasecmp($answer, $solution) === 0;
    },
));
