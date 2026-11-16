<?php
function install_challenge() {
    $query = 'CREATE TABLE IF NOT EXISTS '.GWF_TABLE_PREFIX.'wc_chall_reg_glob (userid INT(11) AUTO_INCREMENT PRIMARY KEY, username VARCHAR(63) CHARACTER SET utf8 COLLATE utf8_general_ci UNIQUE, password CHAR(32) CHARACTER SET ascii COLLATE ascii_bin, level INT(11) NOT NULL DEFAULT 0) ENGINE=myISAM';
    if (false === gdo_db()->queryWrite($query)) { die('ERROR in Table install.'); }
    $users = array(array('Aaron. A. Aaronson', 'thismypass', 0x111), array('Admin', 'ZOMGPASSATTACKS!!!!', 0xfff), array('Peter', 'Peter', 0x222), array('Paul', 'Paul', 0x333), array('Mary', 'Mary', 0x444), array('test', 'test', 0x555), array('Lamb', 'Lamb', 0x666));
    $db = gdo_db();
    foreach ($users as $i => $data) { list($user, $pass, $level) = $data; $query = "REPLACE INTO ".GWF_TABLE_PREFIX."wc_chall_reg_glob VALUES($i, '".$db->escape($user)."', '".md5($pass)."', $level)"; if (false === $db->queryWrite($query)) { die('OOPS'); } }
}
