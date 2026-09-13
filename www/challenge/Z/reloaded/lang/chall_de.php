<?php
$lang = array(
	'your_box' => 'Dein Rechner',
	'title' => 'Zur Challenge',
	'info' => 'Bevor du beginnst, empfehle ich dir, sämtliche Informationen und Lösungen zu speichern.<br/>Wahrscheinlich brauchst du sie später in der Challenge erneut.<br/>Das gilt insbesondere für Passwörter im Erzählerfenster.<br/><br/><a href="%1$s" title="Challenge starten">Challenge starten</a>',
	'narr_1' => 'In dieser Challenge spielst du Trinity aus dem bekannten Film Matrix: Reloaded. Zu Beginn ist deine Mission dieselbe wie im Film: Schalte den Strom der gesamten Stadt ab. Starte den Hack mit einem unauffälligen nmap-Scan im ausführlichen Modus gegen 10.2.2.2 .<br/><br/>Du kannst die Challenge jederzeit mit \'reset\' zurücksetzen.',
	'narr_2' => 'Finde den verwundbaren Dienst, lies über den bekannten Exploit und nenne die Quelldatei, die den Sicherheitsfehler enthält.',
	'narr_3' => 'Gut gemacht, Trinity. Verwende jetzt den berühmten Befehl aus dem Film, um den verwundbaren Dienst auszunutzen.',
	'narr_4' => 'Hoppla, deine Aufgabe wird schwieriger als im Film: Von diesem Knoten aus kannst du das Stromnetz nicht abschalten. Als Nächstes musst du den zentralen MS-SQL-Datenbankserver angreifen. Er ist aus deinem Netzwerk nicht erreichbar. Leite daher deinen lokalen MS-SQL-Port über 10.2.2.2 (Gateway) an den MS-SQL-Port auf 192.168.10.2 weiter. Verwende dazu dein neues SSH-Konto. Auf deinem Rechner bist du root und musst deshalb keinen Benutzernamen angeben.',
	'narr_5' => 'Passwort eingeben:',
	'narr_6' => 'Du bist root auf 10.2.2.2 (Gateway-Server) und hast einen funktionierenden SSH-Tunnel zwischen localhost und dem Datenbankserver (192.168.10.2). Außerdem hast du deinen öffentlichen SSH-Schlüssel zu /root/.ssh/authenticated_keys hinzugefügt, damit du künftig kein Passwort mehr eingeben musst. Melde dich als Nächstes mit dem MS-SQL-Kommandozeilenclient osql am MS SQL Server 2000 an. Dazu musst du eine bekannte MS-SQL-Schwachstelle ausnutzen. Es ist wirklich einfach.',
	'narr_7' => 'Gut gemacht, du bist Systemadministrator auf dem zentralen Datenbankserver. Lege jetzt mit einem einzigen MS-SQL-Befehl einen Windows-Benutzer namens trinity mit dem Passwort Z1ON0101 an.',
	'narr_8' => 'Füge sie der lokalen Gruppe administrators hinzu – wieder mit einem einzigen MS-SQL-Befehl.',
	'narr_9' => 'Richte eine weitere Portweiterleitung ein: von deinem lokalen Remote-Desktop-Port zum Remote-Desktop-Port des Datenbankservers (192.168.10.2), über den Gateway-Server (10.2.2.2).',
	'narr_10' => 'So schwer ist es doch gar nicht, oder? :) Jetzt kannst du dich mit "rdesktop 127.0.0.1 -u trinity -p Z1ON0101" am Remote Desktop des Datenbankservers anmelden. Das ist bereits erledigt; dieser Befehl ist also nicht die einzugebende Lösung. Du öffnest eine neue Konsole auf deinem lokalen Rechner und richtest eine weitere Portweiterleitung ein. Jede Verbindung zu 10.2.2.2 (Gateway) auf Port 222 soll an deinen Rechner 164.109.44.69 auf Port 22 weitergeleitet werden.',
	'narr_11' => 'Gehe davon aus, dass sich der scp-Client auf dem Datenbankserver befindet (wie unter Unix) und der scp-Server auf deinem lokalen Rechner. Kopiere die Datei /home/trinity/nasty_virus in das Verzeichnis c:\\ des Datenbankservers. Benutzername trinity, Passwort MyL0v315N30',
	'narr_12' => 'Oh, eine Eingabeaufforderung.',
	'narr_13' => 'Dein fieser Virus leistet ganze Arbeit gegen das Stromnetz. Es wird Tage dauern, die gesamte Datenbank und das Stromnetz wiederherzustellen. Gut gemacht, Trinity, Mission erfüllt :)',
	'after_1' => ' ',
	'after_2' => 'Starting nmap V. 2.54BETA25
Insufficient responses for TCP sequencing (3), OS detection may be less accurate
Interesting ports on 10.2.2.2:
(The 1539 ports scanned but not shown below are in state: closed)
Port    State           Service         Version
22/tcp  open            ssh             OpenSSH 2.2.0 (protocol 1.0)
...
No exact OS matches for host
...
Nmap run completed -- 1 IP address (1 host up) scanneds
',
	'after_3' => 'Right :)',
	'after_4' => 'Connecting to 10.2.2.2:ssh ... successful.
Attempting to exploit SSHv1 CRC32 ... successful.
Reseting root password to "Z1ON0101".
System open: Access Level <9>
',
	'after_5' => 'Password:',
	'after_6' => 'Welcome to the gateway server, root.',
	'after_7' => 'Welcome to MSSQL. We put the screws in your database!',
	'after_8' => 'Added user trinity.',
	'after_9' => 'Added user trinity to group administrators',
	'after_10' => 'Port Forward 1 done.',
	'after_11' => 'Port Forward 2 done.',
	'after_12' => 'Password:',
	'after_13' => 'OWNED',
	'cmd_help' => 'Dies ist keine Shell. Es ist eher ein Quiz mit Fragen und Antworten. Viel Spaß beim Recherchieren.',
);
