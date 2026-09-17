<?php
$lang = array(
	'title' => 'Bist du blind?',
	'info' => 'Diese Challenge ist eine weitere Fortsetzung von &quot;Blinded by the light&quot;.<br/>
Wieder musst du einen MD5-Passwort-Hash aus der Datenbank auslesen.<br/>
Diesmal darfst du für diese blinde SQL-Injection höchstens %s Abfragen verwenden.<br/>
Außerdem musst du die Aufgabe %s Mal in Folge erfüllen, um die Challenge zu lösen.<br/>
Du erhältst auch den <a href="%s">Quelltext</a> des verwundbaren Skripts, ebenfalls als <a href="%s">hervorgehobene Version</a>.<br/>
Zum Neustart kannst du die Challenge <a href="%s">zurücksetzen</a>.<br/>
<br/>
Danke an Mawekl für seine Motivation!<br/>
<br/>
Viel Glück!',
	'msg_reset' => 'Dein Passwort wurde aus Sicherheitsgründen zufällig geändert.',
	'msg_logged_in' => 'Willkommen zurück, Benutzer. Nach %s Versuchen wärst du jetzt angemeldet.',
	'msg_consec_success' => 'Wow, du konntest den richtigen Hash innerhalb der Vorgaben ermitteln. Du brauchst noch %s Erfolge in Folge, um die Challenge zu lösen.',
	'msg_old_pass' => 'Schade, dass du so schnell aufgibst. Als kleine Hilfe hier dein letzter Hash: %s.',
	'err_too_slow' => 'Du warst in dieser Runde zu langsam. Das geht schneller.',
	'err_login' => 'Dein Passwort ist falsch, Benutzer. Dies war dein %s. Versuch!',
	'err_attempt' => 'Du hast leider %s Versuche gebraucht, um den Hash zu ermitteln. Erlaubt sind %s.',
	'err_wrong' => 'Deine Antwort ist falsch. Dies war dein %s. Versuch!',
	'th_injection' => 'Passwort',
	'th_thehash' => 'Lösung',
	'btn_inject' => 'Injizieren',
	'btn_submit' => 'Absenden',
	'mawekl_blinds_you' => 'Mawekl wirkt Sonnenexplosion auf dich. Dies war dein %s. Versuch.',
);
