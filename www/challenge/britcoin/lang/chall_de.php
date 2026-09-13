<?php
$lang = array(
	'title' => 'Britcoin',
	'subtitle' => 'Eingabe, Berechnung, Ausgabe',
	'hint' => 'Die anfänglichen Blockdaten ändern sich, wenn du die Sprache wechselst -.-',
	'err_nonce_fmt' => 'Ungültige Nonce. Sie muss aus 32 hexadezimalen Zeichen mit Großbuchstaben bestehen.',
	'msg_nice_nonce' => 'Schöne Nonce, aber der Schwierigkeitsgrad wurde nicht erreicht.',
	'info' => 'gizmore, sabretooth und dloser haben ihr gesamtes in Kryptowährungen investiertes Geld verloren.<br/>
Kurzerhand bittet dloser gizmore, eine eigene Kryptowährung zu erstellen.<br/>
<br/>
Doch bevor wir anfangen, fragen wir uns, wie der zugrunde liegende kryptografische Proof-of-Work-Algorithmus funktioniert.<br/>
<br/>
Deine Aufgabe ist, einen Hash zusammen mit einer Nonce zu hashen, um gemäß den <a href="%s">Spezifikationen</a> einen gültigen Proof of Work zu erzeugen.<br/>
<br/>
Bevor ich es vergesse: Dies sind die anfänglichen Blockdaten deiner Sitzung:<br/>
%s
<br/>
Und hier zum Vergleich das berechnete Ergebnis für Nonce null:<br/><b>%s</b><br/>
<br/>
Dein PoW-Hash muss mit %s beginnen.<br/>
Deine Nonce ist die Antwort: 32 hexadezimale Zeichen mit Großbuchstaben.<br/>
<br/>
Viel Glück!<br/>
gizmore',
	'payload' => '{"initial_trust":null,"transactions":[{"from":null,"to":"%s","amt":1,"note":"Mining success"}, {"from":null,"to":"livinskull","amt":1},{"from":null,"to":"sabretooth","amt":1},{"from":"livinskull","to":"sabretooth","amt":0.000000001,"note":"Fraction check"}]}',
);
