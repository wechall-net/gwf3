<?php
final class WeChall_ApiTest extends GWF_Method
{
	public function execute()
	{
		$result = array();
		
		$valid_token = GWF_CSRF::validateToken();
		$result['token'] = GWF_CSRF::generateToken('api_test_token');
		if (!$valid_token)
		{
			$result['error'] = 'Invalid token!';
			return json_encode($result);
		}

		if (!GWF_User::isAdminS())
		{
			$result['error'] = 'Permission denied!';
			return json_encode($result);
		}

		$classname = Common::getPostString('classname');
		$what = Common::getPostString('type');
		$base = Common::getPostString('base');
		$template = Common::getPostString('template');
		$authkey = Common::getPostString('authkey');
		$username = Common::getPostString('username');
		$email = Common::getPostString('email');

		try
		{
			$site = WC_Site::getByClassName($classname);

			if ($what === 'score') {
				list($url, $response) = $site->requestScore(
					Common::getPostString('base'),
					Common::getPostString('template'),
					Common::getPostString('username'),
					Common::getPostString('authkey')
				);
			} else {
				list($url, $response) = $site->requestAccount(
					Common::getPostString('base'),
					Common::getPostString('template'),
					Common::getPostString('username'),
					Common::getPostString('email'),
					Common::getPostString('authkey')
				);
			}

			$result['url'] = $url; 
		}
		catch (Exception $e)
		{
			$result['error'] = $e;
			return json_encode($result);
		}

		if ($response === false)
		{
			$result['error'] = 'Could not access URL!';
			return json_encode($result);
		}

		$result['response'] = $response;

		return json_encode($result);
	}
}
?>
