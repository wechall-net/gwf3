<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::install(__DIR__, function() {
    require_once __DIR__.'/screwed_signup.include';
    screwed_signupCreateUserTable();
});
