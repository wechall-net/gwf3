<?php
if (!defined('CHEAT_SNAKE_SCORE')) {
    define('CHEAT_SNAKE_SCORE', 300000);
}
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'score' => CHEAT_SNAKE_SCORE,
), array(
    'challenge_after' => function() {
        return '<div class="box box_c">'.PHP_EOL.
            '<applet code="SnakeApplet.class" archive="snake.jar?v=1.06" width="500" height="400"><param name="sessid" value="'.GWF_HTML::display(GWF_Session::getSessID()).'" ></param></applet>'.PHP_EOL.
            '</div>'.PHP_EOL;
    },
));
