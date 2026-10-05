function gwf_heartbeat(ms)
{
	var wcHeader = document.getElementById('wc_heartbeat') !== null;
	var heartbeatId = wcHeader ? 'wc_heartbeat' : 'gwf_heartbeat';
	var endpoint = wcHeader ? 'mo=WeChall&me=Heartbeat' : 'mo=Heart&me=Beat';
	var url = GWF_WEB_ROOT+'index.php?'+endpoint+'&time='+new Date().getTime();
	setTimeout('gwf_heartbeat('+ms+');', ms);
	ajaxUpdate(heartbeatId, url);
}
