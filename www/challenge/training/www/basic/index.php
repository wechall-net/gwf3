<?php
require_once dirname(__DIR__, 3).'/WCChallenge.php';

$value = function(array $translations = array()) {
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
	$content = isset($translations['content'])
		? strtr($translations['content'], array('{name}' => $name))
		: 'My name is '.$name.' and iChall.';
	return array($name, $username, $ip, $port, $content);
};

WCChallenge::run(__DIR__, array(
	'name' => function($translations) use ($value) {
		return htmlspecialchars($value($translations)[0], ENT_QUOTES, 'UTF-8');
	},
	'url' => function($translations) use ($value) {
		$data = $value($translations);
		return htmlspecialchars(sprintf('http://%s:%d/%s/%s.html', $data[2], $data[3], $data[1], $data[1]), ENT_QUOTES, 'UTF-8');
	},
	'content' => function($translations) use ($value) {
		return htmlspecialchars($value($translations)[4], ENT_QUOTES, 'UTF-8');
	},
	'length' => function($translations) use ($value) {
		return strlen($value($translations)[4]);
	},
), array(
	'request' => function($chall, $definition, $translations) use ($value) {
		if (!isset($_POST['go'])) {
			return null;
		}
		$data = $value($translations);
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
	'render' => function($chall, $definition, $translations) {
		$port = Common::getPostInt('port', 80);
		return '<div class="box box_c"><form action="index.php" method="post">'.PHP_EOL.
			'<div>'.htmlspecialchars($translations['port'], ENT_QUOTES, 'UTF-8').': <input type="text" name="port" size="5" value="'.htmlspecialchars($port, ENT_QUOTES, 'UTF-8').'" /></div>'.PHP_EOL.
			'<div><input type="submit" name="go" value="'.htmlspecialchars($translations['btn_go'], ENT_QUOTES, 'UTF-8').'" /></div>'.PHP_EOL.
			'</form></div>'.PHP_EOL;
	},
));
?>
