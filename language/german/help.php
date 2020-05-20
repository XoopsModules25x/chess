<?php declare(strict_types=1);

/**
 * Language strings for help page (de)
 *
 * @package chess
 * @subpackage language
 */

/**#@+
 * @ignore
 */

// Note that quotes within the strings need to be escaped.

// --------------------

define('_HE_CHESS_MAIN_TITLE', 'Hilfe zu Schach');

// --------------------

define('_HE_CHESS_INTRO_TITLE', 'Einführung');

define('_HE_CHESS_INTRO_010', '
Dieses Programm arbeitet in Einklang mit den <A href="http://fide.com/official/handbook.asp?level=EE1">Laws of Chess</A>,
bekannt als FIDE,
wie sie von der F&eacute;d&eacute;ration Internationale des &Eacute;checs (International Chess Federation) festgelegt wurden.
');

// --------------------

define('_HE_CHESS_CREATE_TITLE', 'Neue Partien beginnen');

define('_HE_CHESS_CREATE_010', '
Es gibt drei Möglichkeiten, eine Partie zu beginnen:
');
define('_HE_CHESS_CREATE_010_1', 'Eine offene Herausforderung');
define('_HE_CHESS_CREATE_010_2', 'Eine persönliche Herausforderung');
define('_HE_CHESS_CREATE_010_3', 'Eine Partie gegen sich selbst');

define('_HE_CHESS_CREATE_020', '
Eine <EM>offene Herausforderung</EM> kann von jedem angenommen werden.
Eine <EM>persönliche Herausforderung</EM> kann nur vom herausgeforderten Benutzer angenommen werden.
Eine <EM>Partie gegen sich selbst</EM> kann jederzeit begonnen werden, um dieses Programm auszuprobieren.
');

define('_HE_CHESS_CREATE_030', '
	Man kann optional eine Schachbrett-Ausgangsstellung in der Forsyth-Edwards Notation (FEN) angeben.
');

define('_HE_CHESS_CREATE_040', '
Man kann vorgeben, daß der Gegner die Farbe wählt,
daß die Farben zufällig vergeben werden,
oder man kann selbst die eigene Farbe bestimmen.
');

define('_HE_CHESS_CREATE_050', '
	Man kann angeben, ob die Partie bewertet werden soll.
');

define('_HE_CHESS_CREATE_060', '
Eine Partie, die auf einer Herausforderung basiert, wird begonnen, sobald ein anderer Benutzer die Herausforderung annimmt.
Eine Partie gegen sich selbst wird sofort begonnen.
');

define('_HE_CHESS_CREATE_070', '
Ein Herausforderer kann seine Herausforderung jederzeit löschen, sofern sie noch nicht angenommen wurde.
');

// --------------------

define('_HE_CHESS_RATINGS_TITLE', 'Bewertungssystem');

define('_HE_CHESS_RATINGS_CXR', '
	CXR - Eine Adaption des ELO Bewertungssystems, verwendet mit Genehmigung von <A target="_blank" href="http://chess-express.com/">Chess Express Ratings, Inc.</A>
');

define('_HE_CHESS_RATINGS_LINEAR', '
	Linear - Ein sehr einfaches System, das für einen Sieg (Niederlage) eine feste Anzahl an Punkten addiert (subtrahiert).
');

// --------------------

define('_HE_CHESS_PLAY_TITLE', 'Eine Partie spielen');

define('_HE_CHESS_PLAY_010', '
Ein Spieler kann eine der folgenden Aktionen auswählen.
Nicht jede Aktion kann zu jedem Zeitpunkt ausgeführt werden.
');
define('_HE_CHESS_PLAY_010_1', 'Normaler Zug');
define('_HE_CHESS_PLAY_010_2', 'Remis fordern');
define('_HE_CHESS_PLAY_010_3', 'Remis anbieten');
define('_HE_CHESS_PLAY_010_4', 'Remis annehmen');
define('_HE_CHESS_PLAY_010_5', 'Remis ablehnen');
define('_HE_CHESS_PLAY_010_6', 'Aufgeben');
define('_HE_CHESS_PLAY_010_7', 'Partie neu starten');
define('_HE_CHESS_PLAY_010_8', 'Partie löschen');
define('_HE_CHESS_PLAY_010_9', 'Schiedsurteil anfordern');

define('_HE_CHESS_PLAY_020', '
Einen <EM>normalen Zug</EM> kann man machen, wenn man an der Reihe ist.
Mögliche Züge werden <A href="#moving">unten</A> erläutert.
');

define('_HE_CHESS_PLAY_030', '
Man kann <EM>Remis fordern</EM>, wenn die Bedingungen für die 50-Zug-Regel oder die Dreifach-Wiederholungsregel erfüllt sind
und man am Zug ist.
Man kann optional einen (erlaubten) Zug angeben, der dazu führt, daß die Bedingungen erfüllt sind.
Man beachte, daß dieser Zug <EM>ausgeführt wird</EM>.
Wenn die Forderung sich als korrekt herausstellt, wird die Partie in einem Remis beendet.
');

define('_HE_CHESS_PLAY_040', '
Man kann <EM>Remis anbieten</EM>, und zwar unabhängig davon, wer am Zug ist.
Ein Remis-Angebot kann man nicht zurückziehen.
Der Gegner muß das Angebot entweder <EM>annehmen</EM> oder <EM>ablehnen</EM>
Falls der Gegner am Zug ist, kann er das Angebot durch Abgabe eines normalen Zuges ablehnen.
Falls der Gegner das Angebot akzeptiert, endet die Partie sofort in einem Remis.
Man beachte, daß ein Gegner ein Remis-Angebot übersehen kann, 
wenn er am Zug ist und die Schachbrett-Seite bereits für seinen nächsten Zug geöffnet hat.
In einer Partie gegen sich selbst kann man kein Remis anbieten.
');

define('_HE_CHESS_PLAY_050', '
<EM>Aufgeben</EM> kann man jederzeit, unabhängig davon, wer am Zug ist.
Die Partie wird dann beendet, und der Gegner gewinnt.
');

define('_HE_CHESS_PLAY_060', '
In einer Partie gegen sich selbst darf die Partie jederzeit <EM>neu gestartet</EM> werden.
Dann wird die Partie von der Ausgangssituation aus erneut begonnen.
');

define('_HE_CHESS_PLAY_070', '
Eine Partie kann jederzeit <EM>gelöscht</EM> werden.
Die Partie wird dann unwiederruflich aus der Datenbank entfernt.
');

define('_HE_CHESS_PLAY_075', '
In einer Partie gegen sich selbst kann die Partie jederzeit <EM>gelöscht</EM> werden.
Die Partie wird dann unwiederruflich aus der Datenbank entfernt.
');

define('_HE_CHESS_PLAY_080', '
Man kann jederzeit ein <EM>Schiedsurteil anfordern</EM>.
Dies führt dazu, daß die Partie sofort unterbrochen wird, so daß ein Schiedrichter sie überprüfen kann.
Diese Aktion darf jederzeit ausgeführt werden, wenn Bedarf dafür besteht, etwa bei Programmfehlern.
Dann sollte eine kurze Erläuterung im entsprechenden Formularfeld eingetragen werden.
Falls eine längere Erklärung erforderlich sein sollte, sollte dies durch eine Angabe wie "Bitte um Kontaktaufnahme für nähere Details" angezeigt werden.
');

define('_HE_CHESS_PLAY_090', '
Falls JavaScript aktiviert ist, wird über eine Abfrage eine <EM>Bestätigung</EM> eines Zuges oder einer Aktivität verlangt.
Falls dies nicht gewünscht ist, kann die Abfrage durch deselektieren des Bestätigungskästchens deaktiviert werden.
(Es sollte beachtet werden, daß jeder ausgeführte Zug - wie beim "echten" Schach - nicht zurückgenommen werden kann)
Diese Einstellung bezieht sich jeweils nur auf die aktuelle Partie;
d.h. eine Änderung dieser Einstellung in einer Partie hat keine Auswirkungen auf die Einstellung in anderen laufenden Partien.
');

// --------------------

define('_HE_CHESS_ARBITRATION_TITLE', 'Unterbrochene Spiele und Schiedsurteile');

define('_HE_CHESS_ARBITRATION_010', '
Solange eine Partie unterbrochen ist, können weder Züge noch andere Aktionen durchgeführt werden.
Ein Schiedsrichter wird sich den Stand der Partie ansehen und eine Entscheidung gemäß den geltenden Schachregeln fällen.
Falls notwendig, wird der Schiedsrichter die Spieler kontaktieren und/oder anderweitige Erkundigungen einziehen, bevor er seine Entscheidung trifft.
Ein Schiedsrichter hat folgende Möglichkeiten:
');

define('_HE_CHESS_ARBITRATION_010_1', 'Weiterführen des normalen Spiels');
define('_HE_CHESS_ARBITRATION_010_2', 'Remis erklären');
define('_HE_CHESS_ARBITRATION_010_3', 'Partie löschen');

define('_HE_CHESS_ARBITRATION_020', '
Falls notwendig, kann ein Schiedsrichter auch eine laufende Partie unterbrechen.
');

// --------------------

define('_HE_CHESS_DISPLAY_TITLE', 'Ausrichtung des Schachbretts und Aktualisierung der Anzeige');

define('_HE_CHESS_DISPLAY_010', '
Es gibt drei Möglichkeiten zur Anzeige des Schachbretts:
');

define('_HE_CHESS_DISPLAY_010_1', 'Aktive Farbe unten');
define('_HE_CHESS_DISPLAY_010_2', 'Weiß unten');
define('_HE_CHESS_DISPLAY_010_3', 'Schwarz unten');

define('_HE_CHESS_DISPLAY_020', '
Falls man aktiver Teilnehmer einer Partie ist, wird standardmäßig die eigene Farbe unten dargestellt.
Ansonsten ist standardmäßig weiß unten.
');

define('_HE_CHESS_DISPLAY_030', '
Ändert man die Orientierung des Schachbretts, ist es erforderlich, auf <EM>aktualisieren</EM> zu klicken, um die neuen Einstellungen zu übernehmen.
Die Einstellung wird auf den Standard zurückgesetzt, wenn man die Seite verlässt und später erneut besucht.
');

define('_HE_CHESS_DISPLAY_040', '
Man beachte, daß die Anzeige des Schachbretts bei einem Zug des Gegners nicht automatisch aktualisiert wird, wenn die Seite bereits geöffnet wurde.
In diesem Fall ist es erforderlich, die Seite neu zu laden.
');

// --------------------

define('_HE_CHESS_NOTIFY_TITLE', 'Benachrichtigungen und Anmerkungen');

define('_HE_CHESS_NOTIFY_010', '
Man kann beliebige <EM>Benachrichtigungs-Optionen</EM> zu Schachpartien einstellen,
etwa eine Benachrichtigung, wenn ein neuer Zug geführt wurde oder eine neue Partie begonnen wurde.
');

define('_HE_CHESS_NOTIFY_020', '
<EM>Anmerkungen</EM> können zu jeder Partie gemacht werden.
');

// --------------------

define('_HE_CHESS_MOUSE_TITLE', 'Ziehen (mit der Maus)');

define('_HE_CHESS_MOUSE_010', '
Es gibt zwei Möglichkeiten, einen Zug abzugeben: entweder mit der Maus (empfohlen) oder durch Angabe der Zugsequenz des Zuges im entsprechenden Textfeld.
');

define('_HE_CHESS_MOUSE_020', '
Um einen Zug mit der Maus abzugeben, klickt man auf die Figur, die man bewegen will, und dann auf das Feld, auf das man setzen möchte.
(Für eine Rochade zieht man den König auf seine neue Position.)
Jedes angeklickte Feld wird markiert.
Wird ein Bauer in die letzte Reihe gezogen, wird ein Dialog geöffnet, in dem die Figur ausgewählt werden kann, in die der Bauer verwandelt werden soll.
Die Zugsequenz wird bei dieser Vorgehensweise automatisch im entsprechenden Textfeld eingetragen.
Zum Abgeben des Zuges klickt man auf "ziehen".
');

define('_HE_CHESS_MOUSE_030', '
Ziehen mit der Maus erfordert aktiviertes JavaScript.
');

// --------------------

define('_HE_CHESS_NOTATION_TITLE', 'Ziehen (mit Zugsequenz)');

define('_HE_CHESS_NOTATION_010', '
Alternativ zum Ziehen mit der Maus können Züge auch durch Eingabe der Zugsequenz im entsprechenden Textfeld abgegeben werden.
');

define('_HE_CHESS_NOTATION_020', '
Die Zugsequenz eines Zuges setzt sich aus vier Teilen zusammen (und einem fünften bei Verwandlung eines Bauern):
');
define('_HE_CHESS_NOTATION_020_1', 'Figur');
define('_HE_CHESS_NOTATION_020_1_A', 'K (König)');
define('_HE_CHESS_NOTATION_020_1_B', 'Q (Dame)');
define('_HE_CHESS_NOTATION_020_1_C', 'R (Turm)');
define('_HE_CHESS_NOTATION_020_1_D', 'B (Läufer)');
define('_HE_CHESS_NOTATION_020_1_E', 'N (Springer)');
define('_HE_CHESS_NOTATION_020_1_F', 'P (Bauer)');
define('_HE_CHESS_NOTATION_020_2', 'Ausgangsfeld');
define('_HE_CHESS_NOTATION_020_2_A', 'Beispiele: e4, f2, h8');
define('_HE_CHESS_NOTATION_020_3', 'Aktion');
define('_HE_CHESS_NOTATION_020_3_A', '- (ziehen)');
define('_HE_CHESS_NOTATION_020_3_B', 'x (schlagen)');
define('_HE_CHESS_NOTATION_020_4', 'Zielfeld');
define('_HE_CHESS_NOTATION_020_4_A', 'Beispiele: a8, c6, g5');
define('_HE_CHESS_NOTATION_020_5', 'Bauernverwandlung in (sofern erlaubt)');
define('_HE_CHESS_NOTATION_020_5_A', 'mögliche Werte: =Q, =R, =B, =N');

define('_HE_CHESS_NOTATION_030', '
Beispiele für Züge:
');
define('_HE_CHESS_NOTATION_030_1', 'Pe2-e4  (Bauer zieht von e2 auf e4)');
define('_HE_CHESS_NOTATION_030_2', 'Pf4xe5  (Bauer auf f4 schlägt Figur auf e5)');
define('_HE_CHESS_NOTATION_030_3', 'Nf3xe5  (Springer auf f3 schlägt Figur auf e5)');
define('_HE_CHESS_NOTATION_030_4', 'Qd8-h4  (Dame zieht von d8 auf h4)');
define('_HE_CHESS_NOTATION_030_5', 'Ke1-g1  (Weiß führt eine kurze Rochade durch)');
define('_HE_CHESS_NOTATION_030_6', 'Ke8-c8  (Schwarz führt eine lange Rochade durch)');
define('_HE_CHESS_NOTATION_030_7', 'Pe7-e8=Q  (Bauer zieht von e7 auf e8 und wird zu einer Dame)');

define('_HE_CHESS_NOTATION_040', '
Anstatt obiger Zugsequenz kann man auch Standard Algebraic Notation (SAN) verwenden. Beispiele:
');
define('_HE_CHESS_NOTATION_040_1', 'e4  (Bauer zieht auf e4)');
define('_HE_CHESS_NOTATION_040_2', 'fxe5  (Bauer aus der f-Spalte schlägt Figur auf e5)');
define('_HE_CHESS_NOTATION_040_3', 'Nxe5  (Springer schlägt Figur auf e5)');
define('_HE_CHESS_NOTATION_040_4', 'Qh4  (Dame zieht auf h4)');
define('_HE_CHESS_NOTATION_040_5', 'O-O  (kurze Rochade)');
define('_HE_CHESS_NOTATION_040_6', 'O-O-O  (lange Rochade)');
define('_HE_CHESS_NOTATION_040_7', 'e8Q  (Bauer zieht auf e8 und wird zu einer Dame)');

define('_HE_CHESS_NOTATION_050', '
Die Notation für eine Rochade enthält das große "O" (oh), nicht die Zahl 0 (Null).
');

define('_HE_CHESS_NOTATION_060', '
SAN wird auf der <A href="#fide">FIDE</A>-Seite näher beschrieben.
');

define('_HE_CHESS_NOTATION_070', '
<EM>Der Figurbezeichner muß in Großbuchstaben angegeben werden, die Spaltenkoordinaten müssen in Kleinbuchstaben stehen.
Nur gültige, nicht-doppeldeutige Züge werden akzeptiert.</EM>
');

// --------------------

define('_HE_CHESS_EXPORT_TITLE', 'Partien exportieren');

define('_HE_CHESS_EXPORT_010', '
Der aktuelle Stand der Partie wird sowohl in Portable Game Notation (PGN) als auch in Forsyth-Edwards Notation (FEN) angezeigt.
Dabei handelt es sich um weitverbreitete Notationen für die Darstellung von Schachpartien.
Man kann die PGN- oder FEN-Daten der Partie speichern und z.B. 
in andere Schach-Programme importieren.
');

// --------------------

define('_HE_CHESS_MISC_TITLE', 'Verschiedenes');

define('_HE_CHESS_MISC_010', '
Der Patt-Test überprüft nicht, ob eine andere Figur als der König am Zug gehindert wird, weil durch den Zug der eigene König in Schach gerät.
Dadurch kann es vorkommen, daß ein Patt nicht automatisch erkannt wird, obwohl der Spieler keine erlaubten Züge mehr abgeben kann.
Dieses Problem kann durch Anbieten eines Remis, durch Fordern eines Remis (falls anwendbar) oder durch Anfordern eines Schiedsurteils umgangen werden.
Hier ist ein Beispiel für eine solche Situation, in der der Spieler, 
der am Zug ist (Schwarz), keinen gültigen Zug mehr machen kann,
das Patt aber nicht vom Programm erkannt wird:
');
define('_HE_CHESS_MISC_010_IMAGE', 'Patt-Beispiel');

define('_HE_CHESS_MISC_020', '
Artikel 9.6 der FIDE Schachregeln besagt, daß
<EM>Eine Partie gilt als unentschieden, wenn eine Stellung erreicht wurde, in der ein Schach-Matt durch keine Folge gültiger Züge erreicht werden kann,
nicht einmal mit unerfahrenster Spielweise. In diesem Fall ist die Partie sofort beendet.</EM>
Diese Regel ist nicht komplett umgesetzt, da ich [der Programmierer, Anm. d. Übers.] nicht weiß, wie man das implementieren könnte.
Die drei Stellungen König gegen König, König gegen König und Läufer, und König gegen König und Springer führen zum sofortigen Ende der Partie durch Remis.
Kompliziertere Stellungen werden nicht automatisch erkannt und müssen über Angebot eines Remis, 
Fordern eines Remis oder durch ein Schiedsurteil beendet werden.
');

define('_HE_CHESS_MISC_030', '
Es gibt keinerlei Zeitbeschränkungen im Spiel.
Keine der FIDE-Regeln für Zeitmessung oder Zeitbeschränkungen werden hier benutzt.
');

// --------------------

define('_HE_CHESS_ADMIN_TITLE', 'Administration und Schiedsurteile');

define('_HE_CHESS_ADMIN_010', '
Ein <EM>Schiedsrichter</EM> ist ein Benutzer mit Administratorrechten für das Schachmodul.
');

define('_HE_CHESS_ADMIN_020', '
Ein Schiedsrichter kann die Schachmodul-Einstellungen im Xoops-Kontrollpanel einsehen und ändern, und kann Schiedsurteile für Partien und Herausforderungen fällen.
');

define('_HE_CHESS_ADMIN_030', '
Wenn ein Schiedsrichter eine Herausforderung im Kontrollpanel öffnet, kann er diese Herausforderung löschen.
');

define('_HE_CHESS_ADMIN_040', '
Wenn ein Schiedsrichter im Kontrollpanel eine aktive oder unterbrochene Partie öffnet,
sieht er die normale Partie-Seite, mit dem zusätzlichen Eintrag <EM>Schiedsrichter-Optionen</EM>.
Falls die Partie läuft, kann der Schiedsrichter sie unterbrechen.
Falls die Partie unterbrochen ist, kann der Schiedsrichter die Partie normal fortsetzen, Remis bestimmen oder die Partie löschen.
Der Schiedsrichter kann auch die Anzeige der Schiedsrichter-Optionen unterbinden, so daß die Partie-Seite wie für einen normalen Benutzer angezeigt wird.
Die Schiedsrichter-Optionen werden beim nächsten Zugriff auf die Partie über das Kontrollpanel wiederhergestellt.
');

define('_HE_CHESS_ADMIN_050', '
Ein Schiedsrichter kann einstellen, daß er benachrichtigt wird, falls ein Spieler ein Schiedsurteil für eine Partie anfordert.
');

// --------------------

/**#@-*/
