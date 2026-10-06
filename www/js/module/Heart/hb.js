function gwf_heartbeat(ms)
{
	var target = document.getElementById('gwf_heartbeat');
	var endpoint = target && target.getAttribute('data-heartbeat-url');
	var url = (endpoint || GWF_WEB_ROOT+'index.php?mo=Heart&me=Beat')+'&time='+new Date().getTime();
	setTimeout('gwf_heartbeat('+ms+');', ms);
	ajaxUpdate('gwf_heartbeat', url);
}
