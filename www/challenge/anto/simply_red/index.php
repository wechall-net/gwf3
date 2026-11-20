<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(), array(
    'challenge_after' => function($translations) {
        if (!isset($translations['info2'])) {
            return '';
        }
        return '<div style="margin: 10px 20px;">'.str_replace('{image}', 'op.png', $translations['info2']).'</div>';
    },
));
