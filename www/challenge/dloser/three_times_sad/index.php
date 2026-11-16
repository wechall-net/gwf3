<?php
$solution = require __DIR__.'/solution.php';
$base = file_get_contents(__DIR__.'/base.php');
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
), array(
    'challenge_after' => function($translations) use ($base) {
        return GWF_Box::box(
            '<pre>'.htmlspecialchars($base, ENT_QUOTES, 'UTF-8').'</pre>',
            $translations['subtitle']
        );
    },
    'check' => function($answer) use ($solution) {
        for ($i = 0; $i < 56154; $i++) {
            $answer = sha1($answer);
        }
        return strcasecmp($answer, $solution) === 0;
    },
));
