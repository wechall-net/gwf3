<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'challenge_post_content' => function($translations) {
        return '<p style="color:#e5e5e5;">'.$translations['info2_html'].'</p>';
    },
), array(
    'challenge_after' => 'trainingGetSourcedComment',
    'after_footer' => 'trainingGetSourcedEnd',
));

function trainingGetSourcedComment($translations)
{
    $comment = htmlspecialchars($translations['comment'], ENT_QUOTES, 'UTF-8');
    return '<!-- '.$comment.' -->'.PHP_EOL;
}

function trainingGetSourcedEnd($translations)
{
    $solution = htmlspecialchars($translations['solution'], ENT_QUOTES, 'UTF-8');
    return '<!-- '.htmlspecialchars($translations['comment'], ENT_QUOTES, 'UTF-8').' -->'.
        str_repeat(PHP_EOL, 37).
        str_repeat(str_repeat(' ', 74).PHP_EOL, 48).
        str_repeat(' ', 247).'<!-- '.$solution.' -->'.str_repeat(' ', 247).PHP_EOL;
}
