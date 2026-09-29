function gwf_heartbeat(ms)
{
	var heartbeatId = document.getElementById('wc_heartbeat') ? 'wc_heartbeat' : 'gwf_heartbeat';
	var url = GWF_WEB_ROOT+'index.php?mo=Heart&me=Beat&time='+new Date().getTime();
	if (heartbeatId === 'wc_heartbeat') {
		url += '&wc_header=1';
	}
	setTimeout('gwf_heartbeat('+ms+');', ms);
	ajaxUpdate(heartbeatId, url);
}
