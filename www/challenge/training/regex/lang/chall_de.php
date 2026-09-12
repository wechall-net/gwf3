<?php
$lang = array(
	'title' => 'Regex-Trainings-Challenge (Level %1$s)',
	'err_wrong' => 'Deine Antwort ist falsch, oder es gibt eine kürzere Lösung für die Aufgabe.',
	'err_no_match' => 'Dein Muster würde &quot;%1$s&quot; nicht erkennen.',
	'err_matching' => 'Dein Muster würde &quot;%1$s&quot; erkennen, obwohl es das nicht soll.',
	'err_capturing' => 'Dein Muster würde eine Zeichenfolge erfassen, was hier nicht gewünscht ist. Verwende bitte eine nicht erfassende Gruppe.',
	'err_not_capturing' => 'Dein Muster erfasst die gewünschte Zeichenfolge nicht korrekt.',
	'err_too_long' => 'Dein Muster ist länger als die Referenzlösung mit %1$s Zeichen.',
	'msg_next_level' => 'Richtig. Mal sehen, ob du ein Muster für die nächste Aufgabe findest.',
	'msg_solved' => 'Gut gemacht! Das reicht für eine erste Lektion zu regulären Ausdrücken. Mission erfüllt.',
	'info_1' => 'In dieser Challenge sollst du die Regex-Syntax lernen.<br/>
Reguläre Ausdrücke sind ein mächtiges Werkzeug auf deinem Weg zur Beherrschung der Programmierung. Zumindest diese Challenge solltest du also lösen können!<br/>
Gesucht ist bei jeder Aufgabe das kürzestmögliche Muster eines regulären Ausdrucks.<br/>
Beachte außerdem, dass du die Begrenzungszeichen mit angeben musst. Beispielmuster: <b>/joe/i</b>. Das Begrenzungszeichen muss <b>/</b> sein.<br/>
<br/>
Die erste Lektion ist einfach: Gib einen regulären Ausdruck ein, der eine leere Zeichenfolge erkennt und ausschließlich eine leere Zeichenfolge.<br/>',
	'info_2' => 'Einfach genug. Gib als Nächstes einen regulären Ausdruck ein, der ausschließlich die Zeichenfolge \'wechall\' ohne die Anführungszeichen erkennt.',
	'info_3' => 'Gut, statische Zeichenfolgen zu erkennen ist nicht der Hauptzweck regulärer Ausdrücke.<br/>
Als Nächstes sollst du einen Ausdruck eingeben, der gültige Dateinamen bestimmter Bilder erkennt.<br/>
Dein Muster soll alle Bilder mit dem Namen wechall.ext oder wechall4.ext und einer gültigen Bilddateiendung erkennen.<br/>
Gültige Endungen sind .jpg, .gif, .tiff, .bmp und .png.<br/>
Beispiele für gültige Dateinamen: wechall4.tiff, wechall.png, wechall4.jpg, wechall.bmp',
	'info_4' => 'Schön, dass wir jetzt gültige Bilder erkennen. Könntest du bitte auch den Dateinamen ohne Endung erfassen?<br/>
Beispielsweise soll dein Muster bei wechall4.jpg nun wechall4 erfassen/zurückgeben.',
	'info_5' => 'Du machst das gut. Deine nächste Aufgabe ist, alle gültigen HTTP- und HTTPS-URLs zu erkennen, allerdings nur grob.<br/>
Beispiele für gültige URLs sind https://abc.de oder http://abc.foobar/blub.<br/>
Hinweis: Ein Zeichen kannst du auf jeden Fall aus dem Muster ausschließen.',
);
