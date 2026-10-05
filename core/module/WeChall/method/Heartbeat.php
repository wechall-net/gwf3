<?php
/** Return the online header content for WeChall's AJAX heartbeat. */
final class WeChall_Heartbeat extends GWF_Method
{
	public function execute()
	{
		GWF3::setConfig('log_request', false);
		return WC_HTML::displayHeaderOnline($this->module, 20, false);
	}
}
?>
