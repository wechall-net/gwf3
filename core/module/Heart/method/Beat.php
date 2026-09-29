<?php
/** Show online sessions **/
final class Heart_Beat extends GWF_Method
{
	public function execute()
	{
		GWF3::setConfig('log_request', false);
		
		$_GET['ajax'] = 1;
		if (isset($_GET['wc_header']))
		{
			if (false !== ($module = GWF_Module::loadModuleDB('WeChall', false, true, true)))
			{
				$module->includeClass('WC_HTML');
				return WC_HTML::displayHeaderOnline($module, 20, false);
			}
		}

		$cut = time()-GWF_ONLINE_TIMEOUT;
		// The current session's timestamp is not committed until request shutdown.
		$sid = (int) GWF_Session::getSessSID();
		$user = new GWF_User();
		$table = GDO::table('GWF_Session');
		$profiles = '';
		if (false === ($result = $table->select('sess_user,user_name,user_options,user_level', "sess_time>=$cut OR sess_id=$sid", 'user_name ASC', array('user'))))
		{
			return;
		}
	
		$guest = 0;
		$member = 0;
		$total = 0;
		
		$u_count = array();
		$u_users = array();
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
		{
			$total++;
			$uid = $row['sess_user'];
			
			if ($uid == 0)
			{
				$guest++;
				continue;
			}

			$member++;
			$user->setGDOData($row);
			if ($user->isOptionEnabled(GWF_User::HIDE_ONLINE))
			{
				continue;
			}
			
			if (isset($u_count[$uid]))
			{
				$u_count[$uid]++;
			}
			else
			{
				$u_count[$uid] = 1;
				$u_users[$uid] = $user->displayProfileLink();
			}
		}
		$table->free($result);
		
		foreach ($u_count as $uid => $cnt)
		{
			$multi = $cnt > 1 ? "(x$cnt)" : '';
			$profiles .= ', '.$u_users[$uid].$multi;
		}
		
		$profiles = $profiles === '' ? '.' : ': '.substr($profiles, 2).'.';
		
		return sprintf('%s Online%s', $total, $profiles);
	}
}
?>
