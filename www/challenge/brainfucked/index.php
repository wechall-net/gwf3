<?php
require_once dirname(__DIR__).'/WCChallenge.php';
WCChallenge::run(__DIR__, array(
    'hintlink' => function() {
        $hintcode = 'var f=document.createElement("script"); f.setAttribute("type","text/javascript"); f.setAttribute("src", "sourcecode.php"); document.getElementsByTagName("head")[0].appendChild(f);';
        $hintcode = str_replace('"', "'", $hintcode);
        return '<a href="#" onclick="'.$hintcode.'"></a>';
    },
));
