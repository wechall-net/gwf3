<?php
require_once dirname(__DIR__, 2).'/WCChallenge.php';
WCChallenge::install(__DIR__, function() {
    GWF_ForumBoard::init(false, true);
});
