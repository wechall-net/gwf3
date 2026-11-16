<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'challenge_post_content' => function($translations) {
        $alt = htmlspecialchars($translations['img_alt'], ENT_QUOTES, 'UTF-8');
        return '<br/><img src="dots.jpg" alt="'.$alt.'" title="'.$alt.'" />';
    },
));
