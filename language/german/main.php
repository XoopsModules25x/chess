<?php

/**
 * Language strings for main part of module (de)
 *
 * @package    chess
 * @subpackage language
 */

/**#@+
 * @ignore
 */

// Warning: Some of the these constant values contain the sprintf format code "%s".  That format code must not be removed.

define('_MD_CHESS_CREATE_FORM', 'Neue Partie beginnen');
define('_MD_CHESS_ACCEPT_FORM', 'Herausforderung annehmen');
define('_MD_CHESS_DELETE_FORM', 'Herausforderung löschen');

// game type
define('_MD_CHESS_LABEL_GAMETYPE', 'Art der Partie');
define('_MD_CHESS_LABEL_GAMETYPE_OPEN', 'Offene Herausforderung');
define('_MD_CHESS_LABEL_GAMETYPE_USER', 'Persönliche Herausforderung');
define('_MD_CHESS_LABEL_GAMETYPE_SELF', 'Spiel gegen sich selbst');
define('_MD_CHESS_MENU_GAMETYPE_OPEN', _MD_CHESS_LABEL_GAMETYPE_OPEN . ' - Jeder kann die Herausforderung annehmen');
define('_MD_CHESS_MENU_GAMETYPE_USER', _MD_CHESS_LABEL_GAMETYPE_USER . ' - nur der herausgeforderte Benutzer kann die Herausforderung annehmen');
define('_MD_CHESS_MENU_GAMETYPE_SELF', _MD_CHESS_LABEL_GAMETYPE_SELF . ' - Partie mit sich selbst spielen');

// opponent
define('_MD_CHESS_LABEL_OPPONENT', 'Gegner');

// FEN setup
define('_MD_CHESS_LABEL_FEN_SETUP', 'Ausgangssituation');
define('_MD_CHESS_LABEL_FEN_EXPLAIN', 'Optional kann eine Ausgangssituation angegeben werden, die in FEN (Forsyth-Edwards Notation) angegeben wird. Ansonsten wird die Standard-Ausgangssituation gewählt.');

// color preference
define('_MD_CHESS_LABEL_COLOR', 'Meine Farbe wird');
define('_MD_CHESS_RADIO_COLOR_OPPONENT', 'von meinem Gegner bestimmt');
define('_MD_CHESS_RADIO_COLOR_RANDOM', 'zufällig zugewiesen');
define('_MD_CHESS_RADIO_COLOR_WHITE', 'Weiß');
define('_MD_CHESS_RADIO_COLOR_BLACK', 'Schwarz');

// notifications
define('_MD_CHESS_NEVT_ACPT_CHAL_CAP', 'Benachrichtigung senden, wenn meine Herausforderung angenommen wird.');
define('_MD_CHESS_NEVT_MOVE_CAP', 'Benachrichtigung senden, wenn ein neuer Zug in dieser Partie gemacht wurde.');

// buttons
define('_MD_CHESS_CREATE_SUBMIT', 'ziehen!');
define('_MD_CHESS_CREATE_ACCEPT', 'akzeptieren');
define('_MD_CHESS_CREATE_CANCEL', 'abbrechen');
define('_MD_CHESS_CREATE_DELETE', 'löschen');
define('_MD_CHESS_CONFIRM_DELETE', 'Ja, ich bin sicher, daß ich dies löschen will');

// errors
define('_MD_CHESS_ERROR', 'Error');
define('_MD_CHESS_GAMETYPE_INVALID', 'Partie-Typ nicht gültig');
define('_MD_CHESS_FEN_INVALID', 'Ausgangssituation/FEN nicht gültig');
define('_MD_CHESS_OPPONENT_MISSING', 'Der Benutzername des Gegners muß angegeben werden.');
define('_MD_CHESS_OPPONENT_INVALID', 'Der angegebene Benutzer ist unbekannt oder nicht für eine Partie verfügbar.');
define('_MD_CHESS_OPPONENT_SELF', 'Es ist nicht möglich, sich selbst herauszufordern.');
define('_MD_CHESS_GAME_NOT_FOUND', 'Partie nicht gefunden.');
define('_MD_CHESS_GAME_DELETED', 'Partie gelöscht');
define('_MD_CHESS_WRONG_PLAYER2', 'Es ist nicht möglich, eine Herausforderung zu akzeptieren, die an einen anderen Spieler gerichtet ist.');
define('_MD_CHESS_SAME_PLAYER2', 'Es ist nicht möglich, eine Herausforderung von sich selbst anzunehmen.');
define('_MD_CHESS_NO_CONFIRM_DELETE', 'Es ist erforderlich, den Bestätigungskasten zu aktivieren');
define('_MD_CHESS_NO_JAVASCRIPT', 'Javascript ist nicht aktiviert. Die Züge müssen durch textuelle Eintragung abgegeben werden.');
define('_MD_CHESS_MODHEAD_MISSING', 'WARNUNG: <{$xoops_module_header}> fehlt in themes/%s/theme.html.');
define('_MD_CHESS_TOKEN_ERROR', 'Figur fehlt oder ist ungültig.');

// templates
define('_MD_CHESS_LABEL_GAMES', 'Partien');
define('_MD_CHESS_LABEL_NO_GAMES', 'Keine Partien');
define('_MD_CHESS_LABEL_GAME', 'Partie');
define('_MD_CHESS_LABEL_CREATED', 'Begonnen');
define('_MD_CHESS_LABEL_LAST_MOVE', 'Letzter Zug');
define('_MD_CHESS_LABEL_STATUS', 'Status');
define('_MD_CHESS_LABEL_VS', 'gegen');
define('_MD_CHESS_LABEL_DRAW', 'Zug');
define('_MD_CHESS_LABEL_WHITE_WON', 'Weiß gewinnt');
define('_MD_CHESS_LABEL_BLACK_WON', 'Schwarz gewinnt');
define('_MD_CHESS_LABEL_WHITE', 'Weiß');
define('_MD_CHESS_LABEL_BLACK', 'Schwarz');
define('_MD_CHESS_LABEL_TO_MOVE', 'ist am Zug');
define('_MD_CHESS_LABEL_WHITE_TO_MOVE', 'Weiß ist am Zug');
define('_MD_CHESS_LABEL_BLACK_TO_MOVE', 'Schwarz ist am Zug');
define('_MD_CHESS_LABEL_CHALLENGES', 'Herausforderungen');
define('_MD_CHESS_LABEL_NO_CHALLENGES', 'Keine Herausforderungen');
define('_MD_CHESS_LABEL_TYPE', 'Typ');
define('_MD_CHESS_LABEL_CHALLENGER', 'Herausforderer');
define('_MD_CHESS_LABEL_COLOR_OPTION', 'Farbwahl');
define('_MD_CHESS_LABEL_GAME_OVER', 'Spiel beendet, Punktzahl');
define('_MD_CHESS_PGN_FULL', 'Portable Game Notation');
define('_MD_CHESS_PGN_ABBREV', 'PGN');
define('_MD_CHESS_FEN_FULL', 'Forsyth-Edwards Notation');
define('_MD_CHESS_FEN_ABBREV', 'FEN');
define('_MD_CHESS_LABEL_ERROR', '*error*');
define('_MD_CHESS_PROMOTE_TO', 'Bauer verwandeln in');

define('_MD_CHESS_ALT_EMPTY', 'leeres Feld');
define('_MD_CHESS_ALT_WKING', 'weißer König');
define('_MD_CHESS_ALT_WQUEEN', 'weiße Dame');
define('_MD_CHESS_ALT_WROOK', 'weißer Turm');
define('_MD_CHESS_ALT_WBISHOP', 'weißer Läufer');
define('_MD_CHESS_ALT_WKNIGHT', 'weißer Springer');
define('_MD_CHESS_ALT_WPAWN', 'weißer Bauer');
define('_MD_CHESS_ALT_BKING', 'schwarzer König');
define('_MD_CHESS_ALT_BQUEEN', 'schwarze Dame');
define('_MD_CHESS_ALT_BROOK', 'schwarzer Turm');
define('_MD_CHESS_ALT_BBISHOP', 'schwarzer Läufer');
define('_MD_CHESS_ALT_BKNIGHT', 'schwarzer Springer');
define('_MD_CHESS_ALT_BPAWN', 'schwarzer Bauer');

define('_MD_CHESS_CONFIRM', 'bestätigen');

define('_MD_CHESS_BUTTON_MOVE', 'ziehen');

define('_MD_CHESS_NORMAL_MOVE', 'Normaler Zug');
define('_MD_CHESS_RESIGN', 'Aufgeben');
define('_MD_CHESS_OFFER_DRAW', 'Remis anbieten');
define('_MD_CHESS_ACCEPT_DRAW', 'Remis annehmen');
define('_MD_CHESS_REJECT_DRAW', 'Remis ablehnen');
define('_MD_CHESS_CLAIM_DRAW_50', 'Remis fordern (50-Zug-Regel)');
define('_MD_CHESS_CLAIM_DRAW_3', 'Remis fordern (dreifache Wiederholung)');
define('_MD_CHESS_RESTART', 'Partie neu starten');
define('_MD_CHESS_DELETE', 'Partie löschen');
define('_MD_CHESS_WANT_ARBITRATION', 'Schiedsurteil anfordern');
define('_MD_CHESS_MOVE_EXPLAIN', 'Bitte Begründung angeben.');
define('_MD_CHESS_AFTER_MOVE', 'nach Zug');

define('_MD_CHESS_DELETE_WARNING', 'Dieser Vorgang wird die Partie unwiederruflich aus der Datenbank löschen!');

define('_MD_CHESS_BUTTON_REFRESH', 'Aktualisieren');

define('_MD_CHESS_ORIENTATION_ACTIVE', 'Aktive Farbe unten');
define('_MD_CHESS_ORIENTATION_WHITE', 'Weiß unten');
define('_MD_CHESS_ORIENTATION_BLACK', 'Schwarz unten');

define('_MD_CHESS_ARBITER_CONTROLS', 'Schiedsrichter-Optionen');
define('_MD_CHESS_ARBITER_SUSPEND', 'Spiel unterbrechen');
define('_MD_CHESS_ARBITER_RESUME', 'Spiel wieder aufnehmen');
define('_MD_CHESS_ARBITER_DRAW', 'Remis verkünden');
define('_MD_CHESS_ARBITER_EXPLAIN', 'Bitte Begründung angeben.');
define('_MD_CHESS_ARBITER_DELETE', 'Partie löschen');
define('_MD_CHESS_ARBITER_NOACTION', 'Keine Aktion');
define('_MD_CHESS_ARBITER_SHOWCTRL', 'Schiedsrichter-Optionen zeigen');

define('_MD_CHESS_ARBITER_DELETE_WARNING', 'Dieser Vorgang wird die Partie unwiederruflich aus der Datenbank löschen!');

define('_MD_CHESS_BUTTON_ARBITRATE', 'absenden');

define('_MD_CHESS_WHEN_SUSPENDED', 'Wenn unterbrochen');
define('_MD_CHESS_SUSPENDED_BY', 'Unterbrochen von');
define('_MD_CHESS_SUSPENSION_TYPE', 'Art der Unterbrechung');
define('_MD_CHESS_SUSPENSION_REASON', 'Grund der Unterbrechung');
define('_MD_CHESS_UNKNOWN', '*unbekannt*');
define('_MD_CHESS_SUSP_TYPE_ARBITER', 'Vom Schiedsrichter unterbrochen');
define('_MD_CHESS_SUSP_TYPE_PLAYER', 'Schiedsurteil angefordert');

define('_MD_CHESS_MOVE_ENTRY', 'Zug-Eintrag');
define('_MD_CHESS_MOVE_LIST', 'Liste der Züge');
define('_MD_CHESS_EXPORT_FORMATS', 'Exportieren');
define('_MD_CHESS_CAPTURED_PIECES', 'Eroberte Figuren');

// Notifications
define('_MD_CHESS_WHITE', 'Weiß');
define('_MD_CHESS_BLACK', 'Schwarz');
define('_MD_CHESS_RESIGNED', 'hat aufgegeben.');
define('_MD_CHESS_OFFERED_DRAW', 'hat Remis angeboten.');
define('_MD_CHESS_ACCEPTED_DRAW', 'hat Remis angenommen.');
define('_MD_CHESS_REJECTED_DRAW', 'hat Remis abgelehnt.');
define('_MD_CHESS_RQSTED_ARBT', 'hat Schiedsurteil angefordert.');
define('_MD_CHESS_BEEN_SUSPENDED', 'Partie ist unterbrochen, Schiedsurteil wird erwartet.');
define('_MD_CHESS_AS_ARBITER', 'ist Schiedsrichter');
define('_MD_CHESS_RESUMED_PLAY', 'hat Partie wieder aufgenommen.');
define('_MD_CHESS_DECLARED_DRAW', 'hat Remis gefordert.');
define('_MD_CHESS_DELETED_GAME', 'hat die Partie gelöscht.');
define('_MD_CHESS_SUSPENDED_PLAY', '$username (Schiedsrichter) hat die Partie unterbrochen.');

// FEN setup errors
define('_MD_CHESS_FENBAD_LENGTH', 'ungültige Länge');
define('_MD_CHESS_FENBAD_FIELD_COUNT', 'falsche Anzahl an Feldern');
define('_MD_CHESS_FENBAD_PP_INVALID', 'Figur ungültig plaziert.');
define('_MD_CHESS_FENBAD_AC_INVALID', 'aktive Farbe ungültig');
define('_MD_CHESS_FENBAD_CA_INVALID', 'ungültige Rochade');
define('_MD_CHESS_FENBAD_EP_INVALID', 'en passant Zielfeld ungültig');
define('_MD_CHESS_FENBAD_HC_INVALID', 'ungültige Zeit für halben Zug');
define('_MD_CHESS_FENBAD_FN_INVALID', 'ungültige Zuganzahl');
define('_MD_CHESS_FENBAD_MATERIAL', 'unzureichende Paar-Informationen');
define('_MD_CHESS_FENBAD_IN_CHECK', 'aktiver Spieler darf Gegner nicht in Schach haben');
define('_MD_CHESS_FENBAD_CA_INCONSISTENT', 'Möglichkeit zur Rochade in dieser Spielsituation ungültig');
define('_MD_CHESS_FENBAD_EP_COLOR', 'en passant Zielfeld hat die falsche Farbe');
define('_MD_CHESS_FENBAD_EP_NO_PAWN', 'en passant Zielfeld für nicht existenten Bauern');

// Move-messages
// Some of these messages are processed with eval() in ChessGame::move_msg(), and may contain parameters $param[1], $param[2], etc.
define('_MD_CHESS_MOVE_UNKNOWN', 'ERROR (autocomplete): format ist unbekannt!');
define('_MD_CHESS_MOVE_PAWN_MAY_BECOME', 'ERROR (autocomplete): Ein Bauer kann nur zu einem Turm, einem Läufer, einem Springer oder einer Dame werden!');
define('_MD_CHESS_MOVE_USE_X', 'ERROR (autocomplete): x erforderlich, weist auf Angriff hin');
define('_MD_CHESS_MOVE_COORD_INVALID', 'ERROR (autocomplete): Feld {$param[1]} existiert nicht');
define('_MD_CHESS_MOVE_CANNOT_FIND_PAWN', 'ERROR (autocomplete): Kein {$param[1]} Bauer in Spalte {$param[2]}');
define('_MD_CHESS_MOVE_USE_NOTATION', 'ERROR (autocomplete): Bitte folgende Notation für Bauernangriffe benutzen: [a-h]x[a-h][1-8] (siehe Hilfeseiten)');
define('_MD_CHESS_MOVE_NO_PAWN', 'ERROR (autocomplete): Es gibt keinen Bauern in Spalte in {$param[1]}');
define('_MD_CHESS_MOVE_TWO_PAWNS', 'ERROR (autocomplete): Es gibt mehr als einen Bauern in Spalte {$param[1]}');
define('_MD_CHESS_MOVE_NO_FIGURE', 'ERROR (autocomplete): Es gibt keine Figur {$param[1]} = {$param[2]}');
define('_MD_CHESS_MOVE_NEITHER_CAN_REACH', 'ERROR (autocomplete): keiner von {$param[1]} = {$param[2]} kann {$param[3]} erreichen');
define('_MD_CHESS_MOVE_BOTH_CAN_REACH', 'ERROR (autocomplete): beide {$param[1]} = {$param[2]} können {$param[3]} erreichen');
define('_MD_CHESS_MOVE_AMBIGUOUS', 'ERROR (autocomplete): Mehrdeutigkeit konnte nicht gelöst werden');
define('_MD_CHESS_MOVE_UNDEFINED', 'ERROR: undefiniert');
define('_MD_CHESS_MOVE_GAME_OVER', 'ERROR: Diese Partie ist beendet. Es ist nicht möglich, weitere Züge abzusetzen.');
define('_MD_CHESS_MOVE_NO_CASTLE', 'ERROR: Rochade nicht möglich.');
define('_MD_CHESS_MOVE_INVALID_PIECE', 'ERROR: Nur N (Springer), B (Läufer), R (Turm) und Q (Dame) sind gültige Figurenbezeichner');
define('_MD_CHESS_MOVE_UNKNOWN_FIGURE', 'ERROR: Figur {$param[1]} ist nicht bekannt!');
define('_MD_CHESS_MOVE_TILE_EMPTY', 'ERROR: Feld {$param[1]} ist leer');
define('_MD_CHESS_MOVE_NOT_YOUR_PIECE', 'ERROR: Diese Figur gehört nicht zu den eigenen!');
define('_MD_CHESS_MOVE_NOEXIST_FIGURE', 'ERROR: Diese Figur existiert nicht!');
define('_MD_CHESS_MOVE_START_END_SAME', 'ERROR: Position und Zielfeld sind identisch!');
define('_MD_CHESS_MOVE_UNKNOWN_ACTION', 'ERROR: {$param[1]} ist unbekannt! Bitte "-" für Bewegungen und "x" für Angriffe angeben.');
define('_MD_CHESS_MOVE_OUT_OF_RANGE', 'ERROR: Feld {$param[1]} ist außer Reichweite für {$param[2]} auf {$param[3]}!');
define('_MD_CHESS_MOVE_OCCUPIED', 'ERROR: Feld {$param[1]} ist besetzt. Zug nicht möglich.');
define('_MD_CHESS_MOVE_NO_EN_PASSANT', 'ERROR: en-passant nicht möglich!');
define('_MD_CHESS_MOVE_ATTACK_EMPTY', 'ERROR: Feld {$param[1]} ist leer. Angriff nicht möglich."');
define('_MD_CHESS_MOVE_ATTACK_SELF', 'ERROR: Angriff auf eigene Figur auf {$param[1]} nicht möglich.');
define('_MD_CHESS_MOVE_IN_CHECK', 'ERROR: Zug nicht möglich, würde den eigenen König in Schach setzen.');
define('_MD_CHESS_MOVE_CASTLED_SHORT', 'Kurze Rochade ausgeführt.');
define('_MD_CHESS_MOVE_CASTLED_LONG', 'Lange Rochade ausgeführt.');
define('_MD_CHESS_MOVE_MOVED', '{$param[1]} von {$param[2]} nach {$param[3]} gesetzt');
define('_MD_CHESS_MOVE_CAPTURED', '{$param[1]} schlägt {$param[2]} auf {$param[3]}');
define('_MD_CHESS_MOVE_PROMOTED', 'und wird zu {$param[1]}!');
define('_MD_CHESS_MOVE_CHECKMATE', 'Schachmatt!');
define('_MD_CHESS_MOVE_STALEMATE', 'Patt!');
define('_MD_CHESS_MOVE_MATERIAL', 'unzureichende Paar-Information!');
define('_MD_CHESS_MOVE_KING', 'König');
define('_MD_CHESS_MOVE_QUEEN', 'Dame');
define('_MD_CHESS_MOVE_ROOK', 'Turm');
define('_MD_CHESS_MOVE_BISHOP', 'Läufer');
define('_MD_CHESS_MOVE_KNIGHT', 'Springer');
define('_MD_CHESS_MOVE_PAWN', 'Bauer');
define('_MD_CHESS_MOVE_EMPTY', 'leer');

// miscellaneous
define('_MD_CHESS_GAME_CONFIRM', 'Einstellungen für diese Partie bestätigen.');
define('_MD_CHESS_GAME_CREATED', 'Partie erstellt');
define('_MD_CHESS_GAME_STARTED', 'Partie begonnen');
define('_MD_CHESS_LABEL_DATE_CREATED', 'Datum erstellt');
define('_MD_CHESS_LABEL_GAME_SUSPENDED', 'Partie unterbrochen');
define('_MD_CHESS_WHITE_OFFERED_DRAW', 'Weiß hat Remis angeboten. Schwarz muß annehmen oder ablehnen.');
define('_MD_CHESS_BLACK_OFFERED_DRAW', 'Schwarz hat Remis angeboten. Weiß muß annehmen oder ablehnen.');

// PGN movetext comments for drawn games - must not contain comment delimiters '{' or '}'
define('_MD_CHESS_DRAW_STALEMATE', 'Remis durch Patt.');
define('_MD_CHESS_DRAW_NO_MATE', 'Remis, da kein Schachmatt mehr möglich.');
define('_MD_CHESS_DRAW_BY_AGREEMENT', 'Remis in beidseitigem Einvernehmen.');
define('_MD_CHESS_DRAW_DECLARED', 'Remis vom Schiedsrichter entschieden, Begründung: %s.');
define('_MD_CHESS_DRAW_50', 'Remis durch 50-Zug-Regel.');
define('_MD_CHESS_DRAW_3', 'Remis durch dreimalige-Wiederholung-Regel, ausgehend von Brettstellung vor den Zügen %s.');

define('_MD_CHESS_NO_DRAW_50', 'Die Bedingungen für ein Remis nach der 50-Zug-Regel wurden nicht erfüllt.');
define('_MD_CHESS_NO_DRAW_3', 'Die Bedingungen für ein Remis nach der dreimalige-Wiederholung-Regel wurden nicht erfüllt.');

// menu options
define('_MD_CHESS_SHOW_GAMES_INPLAY', 'Zeige nur aktive Partien');
define('_MD_CHESS_SHOW_GAMES_CONCLUDED', 'Zeige nur beendete Partien');
define('_MD_CHESS_SHOW_GAMES_BOTH', 'Zeige alle Partien');
define('_MD_CHESS_SHOW_GAMES_RATED', 'Zeige nur bewertete Partien');
define('_MD_CHESS_SHOW_GAMES_UNRATED', 'Zeige bewertete und unbewertete Partien');
define('_MD_CHESS_SHOW_CHALLENGES_OPEN', 'Zeige nur offene Herausforderungen');
define('_MD_CHESS_SHOW_CHALLENGES_USER', 'Zeige nur persönliche Herausforderungen');
define('_MD_CHESS_SHOW_CHALLENGES_BOTH', 'Zeige alle Herausforderungen');

// ratings
define('_MD_CHESS_RATED_GAME', 'Bewertete Partie');
define('_MD_CHESS_RATINGS_OFF', 'Bewertungen nicht aktiv.');
define('_MD_CHESS_PLAYER_RATINGS', 'Bewertung des Spielers');
define('_MD_CHESS_RATING', 'Bewertung');
define('_MD_CHESS_PLAYER', 'Spieler');
define('_MD_CHESS_GAMES_PLAYED', 'Bewertete beendete Partien');
define('_MD_CHESS_PROVISIONAL', 'vorläufige Bewertung (weniger als %s bewertete Partien gespielt)');
define('_MD_CHESS_NA', 'n/a'); // not applicable or not available
define('_MD_CHESS_NO_RATING_INFO', 'Keine Bewertungen gefunden.');
define('_MD_CHESS_RECALC_RATINGS', 'Bewertungen für alle Spieler neu berechnen (nur für Modul-Administratoren möglich)');
define('_MD_CHESS_SUBMIT_BUTTON', 'absenden');
define('_MD_CHESS_RECALC_CONFIRM', 'Ja, ich bin sicher, daß ich das tun will.');
define('_MD_CHESS_RECALC_DONE', 'Bewertungen neu berechnet.');
define('_MD_CHESS_RECALC_NOT_DONE', 'Bewertungen nicht neu berechnet, da Bestätigungskästchen nicht gesetzt war.');
define('_MD_CHESS_LAST_ACTIVITY', 'Letzte Aktivität');
define('_MD_CHESS_STATUS', 'Status');
define('_MD_CHESS_DRAWN', 'Remis');
define('_MD_CHESS_WON', 'gewonnen');
define('_MD_CHESS_LOST', 'verloren');
define('_MD_CHESS_RANKED', 'bewertet');
define('_MD_CHESS_RATED_GAMES_PLAYED', 'bewertete Partien');
define('_MD_CHESS_CHALLENGES_FOR', 'Herausforderungen für: %s');
define('_MD_CHESS_GAMES_FOR', 'Schachpartien für: %s');
define('_MD_CHESS_STATS_FOR', 'Statistiken für: %s');
define('_MD_CHESS_SELECT_PLAYER', 'Auswahl Spieler und Sichtbarkeit');
define('_MD_CHESS_USERNAME', 'Benutzername');
define('_MD_CHESS_SHOW_ALL_GAMES', 'Zeige alle Partien');
define('_MD_CHESS_SHOW_EXCEPT_SELFPLAY', 'Zeige alle Partien außer denen gegen mich selbst');
define('_MD_CHESS_SHOW_RATED_ONLY', 'Zeige nur bewertete Partien');
define('_MD_CHESS_PLAYER_NOT_FOUND', 'Keine Partie-Informationen für diesen Spieler gefunden.');
define('_MD_CHESS_VIEW_PROFILE', 'Zeige Profil dieses Spielers');
