<?php

/**
 * Language strings for module initialization (de)
 *
 * @package    chess
 * @subpackage language
 */

/**#@+
 * @ignore
 */

// Warning: Some of the these constant values contain the sprintf format code "%s".  That format code must not be removed.

// Main
define('_MI_CHESS', 'Schach');
define('_MI_CHESS_DES', 'Ermöglicht den Benutzern, gegeneinander Schach zu spielen.');
define(
    '_MI_CHESS_CREDITS',
    '
	Meiko Jensen (german language pack).
	<br>
	CXR Rating System used by permission of <A target="_blank" href="http://chess-express.com/">Chess Express Ratings, Inc.</A>
'
);

// Blocks
define('_MI_CHESS_GAMES', 'Letzte Schachpartien');
define('_MI_CHESS_GAMES_DES', 'Liste der letzten Schachpartien');
define('_MI_CHESS_CHALLENGES', 'Letzte Schach-Herausforderungen');
define('_MI_CHESS_CHALLENGES_DES', 'Liste der letzten Schach-Herausforderungen');
define('_MI_CHESS_PLAYERS', 'Beste Schachspieler');
define('_MI_CHESS_PLAYERS_DES', 'Liste der besten Schachspieler');

// Templates
define('_MI_CHESS_INDEX', 'Schach Übersicht');
define('_MI_CHESS_GAME', 'Schachpartie');
define('_MI_CHESS_MOVE_FORM', 'Schachzug-Seite');
define('_MI_CHESS_PROMOTE_POPUP', 'Schach-Bauernverwandlungsfenster');
define('_MI_CHESS_BOARD', 'Schachbrett');
define('_MI_CHESS_PREFS_FORM', 'Einstellungen für Schach');
define('_MI_CHESS_ARBITER_FORM', 'Schach-Schiedsrichter');
define('_MI_CHESS_HELP', 'Schach-Hilfe');
define('_MI_CHESS_RATINGS', 'Schachspieler-Bewertungen (alle Spieler)');
define('_MI_CHESS_PLAYER_STATS', 'Schachspieler-Statistik');

// Menu
define('_MI_CHESS_SMNAME1', 'Hilfe');
define('_MI_CHESS_SMNAME2', 'Liste der Partien');
define('_MI_CHESS_SMNAME3', 'Neue Partie');
define('_MI_CHESS_SMNAME4', 'Bewertungen');
define('_MI_CHESS_SMNAME5', 'Meine Partien');

// Rating systems (used in config)
define('_MI_CHESS_RATING_SYSTEM_NONE', 'kein');
define('_MI_CHESS_RATING_SYSTEM_CXR', 'CXR');
define('_MI_CHESS_RATING_SYSTEM_LINEAR', 'Linear');

// Config
define('_MI_CHESS_GROUPS_PLAY', 'Schachspiel-Recht');
define('_MI_CHESS_GROUPS_PLAY_DES', 'Ein Benutzer in jeder der ausgewählten Gruppen darf andere Spieler herausfordern, Herausforderungen annehmen und gegen sich selbst spielen.');
define('_MI_CHESS_GROUPS_DELETE', 'Partie-löschen-Recht');
define('_MI_CHESS_GROUPS_DELETE_DES', 'Ein Benutzer in jeder der ausgewählten Gruppen darf eine Partie löschen, die er selbst spielt. Unabhängig davon, ob er dieses Recht hat, darf er Partien gegen sich selbst jederzeit löschen.');
define('_MI_CHESS_ALLOW_SETUP', 'Anfangsstellung ändern?');
define('_MI_CHESS_ALLOW_SETUP_DES', 'Darf ein Spieler die anfängliche Stellung der Figuren auf dem Schachbrett über die Forsyth-Edwards Notation (FEN) ändern?');
define('_MI_CHESS_MAX_ITEMS', 'Maximale Anzahl an Einträgen pro Seite');
define('_MI_CHESS_MAX_ITEMS_DES', 'Bezogen auf Partien, Herausforderungen und Spieler.');
define('_MI_CHESS_RATING_SYSTEM', 'Spielerbewertungssystem');
define(
    '_MI_CHESS_RATING_SYSTEM_DES',
    '
	Verfügbare Bewertungssysteme:
	<br><br>
	&nbsp;&nbsp;' . _MI_CHESS_RATING_SYSTEM_CXR . '    - Adaptation des ELO Bewertungssystem, Verwendung erlaubt durch <A target="_blank" href="http://chess-express.com/">Chess Express Ratings, Inc.</A>
	<br><br>
	&nbsp;&nbsp;' . _MI_CHESS_RATING_SYSTEM_LINEAR . ' - Ein sehr einfaches System, das für jeden Sieg (Niederlage) eine feste Anzahl an Punkten addiert (abzieht).
	<br><br>
	Die Auswahl "' . _MI_CHESS_RATING_SYSTEM_NONE . '" schaltet das Bewertungssystem ab.
	<br><br>
	Nach Änderung dieser Auswahl sollten die Spielerbewertungen aktualisiert werden (unter Hauptmenü >> Schach >>
	' . _MI_CHESS_SMNAME4 . ').
'
);
define('_MI_CHESS_INITIAL_RATING', 'Anfängliche Spielerbewertung');
define(
    '_MI_CHESS_INITIAL_RATING_DES',
    '
	Falls das "' . _MI_CHESS_RATING_SYSTEM_CXR . '" Bewertungssystem gewählt wird, sollte dieser Wert zwischen 800 und 2000 liegen.
	<br><br>
	Nur wirksam, falls ein Bewertungssystem ausgewählt wurde.
	<br><br>
	Nach Änderung dieser Auswahl sollten die Spielerbewertungen aktualisiert werden (unter Hauptmenü >> Schach >> ' . _MI_CHESS_SMNAME4 . ').
'
);
define('_MI_CHESS_ALLOW_UNRATED', 'Unbewertete Partien erlauben?');
define(
    '_MI_CHESS_ALLOW_UNRATED_DES',
    '
	Darf ein Benutzer bei einer Herausforderung auswählen, daß diese Partie nicht in die Bewertung eingeht?
	<br><br>
	Nur wirksam, falls ein Bewertungssystem ausgewählt wurde.
'
);

// Notifications

define('_MI_CHESS_NCAT_GAME', 'Partie');
define('_MI_CHESS_NCAT_GAME_DES', 'Dies ist die Kategorie Partie.');

define('_MI_CHESS_NCAT_GLOBAL', 'Global');
define('_MI_CHESS_NCAT_GLOBAL_DES', 'Dies ist die Kategorie Schach.');

define('_MI_CHESS_NEVT_MOVE', 'Neuer Zug');
define('_MI_CHESS_NEVT_MOVE_CAP', 'Benachrichtigen, wenn in dieser Partie ein neuer Zug gemacht wurde.');
define('_MI_CHESS_NEVT_MOVE_DES', 'Beschreibung des neuen Zuges');
define('_MI_CHESS_NEVT_MOVE_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : Neuer Zug');

define('_MI_CHESS_NEVT_CHAL_USER', 'persönliche Herausforderung');
define('_MI_CHESS_NEVT_CHAL_USER_CAP', 'Benachrichtigen, wenn ich herausgefordert werde.');
define('_MI_CHESS_NEVT_CHAL_USER_DES', '');
define('_MI_CHESS_NEVT_CHAL_USER_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : persönliche Herausforderung');

define('_MI_CHESS_NEVT_CHAL_OPEN', 'Offene Herausforderung');
define('_MI_CHESS_NEVT_CHAL_OPEN_CAP', 'Benachrichtigen, wenn eine neue offene Herausforderung erstellt wird.');
define('_MI_CHESS_NEVT_CHAL_OPEN_DES', '');
define('_MI_CHESS_NEVT_CHAL_OPEN_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : Offene Herausforderung');

define('_MI_CHESS_NEVT_ACPT_CHAL', 'Herausforderung akzeptiert');
define('_MI_CHESS_NEVT_ACPT_CHAL_CAP', 'Benachrichtigen, wenn jemand meine Herausforderung annimmt.');
define('_MI_CHESS_NEVT_ACPT_CHAL_DES', '');
define('_MI_CHESS_NEVT_ACPT_CHAL_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : Herausforderung angenommen');

define('_MI_CHESS_NEVT_RQST_ARBT', 'Schiedsurteil angefordert (admin only)');
define('_MI_CHESS_NEVT_RQST_ARBT_CAP', 'Benachrichtigen, wenn Schiedsurteil angefordert wird.');
define('_MI_CHESS_NEVT_RQST_ARBT_DES', '');
define('_MI_CHESS_NEVT_RQST_ARBT_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : Schiedsurteil angefordert');

// Admin menu items
define('_MI_CHESS_ADMENU1', 'Unterbrochene Partien');
define('_MI_CHESS_ADMENU2', 'Aktive Partien');
define('_MI_CHESS_ADMENU3', 'Herausforderungen');

// Install/upgrade
define('_MI_CHESS_OLD_VERSION', 'Direktes Update von Version "%s" nicht unterstützt! Bitte Datei "%s" lesen.');
define('_MI_CHESS_RATINGS_TABLE_1', 'Prüfe, ob Tabelle "%s" bereits existiert ...');
define('_MI_CHESS_RATINGS_TABLE_2', ' ... Existenzprüfung fehlgeschlagen für Tabelle "%s": (%s) %s');
define('_MI_CHESS_RATINGS_TABLE_3', ' ... Tabelle "%s" existiert bereits, also wurde dieses Update vermutlich bereits ausgeführt.');
define('_MI_CHESS_OK', ' ... Ok');
define('_MI_CHESS_CHK_DB_TABLES', 'Prüfe Datenbank-Tabellen ...');
define('_MI_CHESS_GAMES_TABLE_1', 'Inspiziere Tabelle "%s" vor der Änderung ...');
define('_MI_CHESS_GAMES_TABLE_2', ' ... Inspektion fehlgeschlagen für Tabelle "%s": (%s) %s');
define('_MI_CHESS_GAMES_TABLE_3', ' ... die Spalte "%s" in der Tabelle "%s" darf nur folgende Werte enthalten: %s.');
define('_MI_CHESS_GAMES_TABLE_4', ' ... Bitte die Fehler für diese Tabelle korrigieren und das Update erneut asführen.');
define('_MI_CHESS_UPDATING_DATABASE', 'Aktualisiere Datenbank-Tabellen ...');
define('_MI_CHESS_INIT_RATINGS_TABLE', 'Initialisiere Bewertungstabellen ...');
define('_MI_CHESS_UPDATE_SUCCESSFUL', 'Update erfolgreich abgeschlossen.');

//2.01

//Config
define('MI_CHESS_EDITOR_ADMIN', 'Editor: Admin');
define('MI_CHESS_EDITOR_ADMIN_DESC', 'Select the Editor to use by the Admin');
define('MI_CHESS_EDITOR_USER', 'Editor: User');
define('MI_CHESS_EDITOR_USER_DESC', 'Select the Editor to use by the User');

//Help
define('_MI_CHESS_DIRNAME', basename(dirname(__DIR__, 2)));
define('_MI_CHESS_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_CHESS_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_CHESS_OVERVIEW', 'Overview');

//define('_MI_CHESS_HELP_DIR', __DIR__);

//help multi-page
define('_MI_CHESS_DISCLAIMER', 'Disclaimer');
define('_MI_CHESS_LICENSE', 'License');
define('_MI_CHESS_SUPPORT', 'Support');

/**#@-*/
