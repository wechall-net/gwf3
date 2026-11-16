<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';

$value = function() {
	$user = GWF_User::getStaticOrGuest();
	$name = $user->getVar('user_name');
	$username = urlencode($name);
	$ip = $_SERVER['REMOTE_ADDR'];
	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
		$ip = "[$ip]";
	} elseif (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		$ip = null;
	}
	$port = Common::getPostInt('port', 80);
	$content = 'My name is '.$name.' and iChall.';
	return array($name, $username, $ip, $port, $content);
};

WCChallenge::run(__DIR__, array(
	'name' => function() use ($value) {
		return htmlspecialchars($value()[0], ENT_QUOTES, 'UTF-8');
	},
	'url' => function() use ($value) {
		$data = $value();
		return htmlspecialchars(sprintf('http://%s:%d/%s/%s.html', $data[2], $data[3], $data[1], $data[1]), ENT_QUOTES, 'UTF-8');
	},
	'content' => function() use ($value) {
		return htmlspecialchars($value()[4], ENT_QUOTES, 'UTF-8');
	},
	'length' => function() use ($value) {
		return strlen($value()[4]);
	},
), array(
	'request' => function($chall, $definition, $translations) use ($value) {
		if (!isset($_POST['go'])) {
			return null;
		}
		$data = $value();
		$url = sprintf('http://%s:%d/%s/%s.html', $data[2], $data[3], $data[1], $data[1]);
		$response = GWF_HTTP::getFromURL($url);
		if ($response === false) {
			return array('response' => GWF_HTML::error('WWW Basics', $translations['err_file_not_found']));
		}
		if ($response !== $data[4]) {
			$values = array(
				'{response_length}' => strlen($response),
				'{response}' => htmlspecialchars($response, ENT_QUOTES, 'UTF-8'),
				'{content_length}' => strlen($data[4]),
				'{content}' => htmlspecialchars($data[4], ENT_QUOTES, 'UTF-8'),
			);
			$message = strtr($translations['err_wrong'], $values);
			return array('response' => GWF_HTML::error('WWW Basics', $message));
		}
		return true;
	},
	'render' => function() {
		$port = Common::getPostInt('port', 80);
		return '<div class="box box_c"><form action="index.php" method="post">'.PHP_EOL.
			'<div>Port: <input type="text" name="port" size="5" value="'.htmlspecialchars($port, ENT_QUOTES, 'UTF-8').'" /></div>'.PHP_EOL.
			'<div><input type="submit" name="go" value="I have set it up. Please check my server." /></div>'.PHP_EOL.
			'</form></div>'.PHP_EOL;
	},
));
?>
