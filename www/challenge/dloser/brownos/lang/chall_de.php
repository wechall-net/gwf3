<?php
$lang = array(
	'title' => 'Das BrownOS',
	'subtitle' => 'Spickzettel',
	'info' =>
		'Uns erreichen Berichte über ein neuartiges Betriebssystem, an dem Gizmore arbeitet. Scans haben einen zusätzlichen offenen Port auf wechall.net entdeckt, der damit zusammenhängen könnte. Außerdem hat einer unserer Mülltaucher einen Teil eines mutmaßlichen Spickzettels für etwas namens "BrownOS" gefunden.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Untersuche bitte den Dienst auf wc3.wechall.net, Port 61221.<br/>'.PHP_EOL,
	// Technical challenge material: preserve exactly as in English.
	'cheatsheet' =>
		'<pre>FF: End Of Code marker'.PHP_EOL.
		PHP_EOL.
		'BrownOS[&lt;syscall&gt; &lt;argument&gt; FD &lt;rest&gt; FD] -&gt; BrownOS[&lt;rest&gt; &lt;result&gt; FD]'.PHP_EOL.
		PHP_EOL.
		'Quick debug: 05 00 FD 00 05 00 FD 03 FD FE FD 02 FD FE FD FE'.PHP_EOL.
		'For example: QD ?? FD  or  ?? ?? FD QD FD'.PHP_EOL,
);
