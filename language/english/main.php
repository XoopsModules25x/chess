<?php declare(strict_types=1);

/**
 * Language strings for main part of module (en)
 *
 * @package chess
 * @subpackage language
 */

/**#@+
 * @ignore
 */

// Warning: Some of the these constant values contain the sprintf format code "%s".  That format code must not be removed.

define('_MD_CHESS_CREATE_FORM', 'Create a new game');
define('_MD_CHESS_ACCEPT_FORM', 'Accept challenge');
define('_MD_CHESS_DELETE_FORM', 'Delete challenge');

// game type
define('_MD_CHESS_LABEL_GAMETYPE', 'Game type');
define('_MD_CHESS_LABEL_GAMETYPE_OPEN', 'Open challenge');
define('_MD_CHESS_LABEL_GAMETYPE_USER', 'Individual challenge');
define('_MD_CHESS_LABEL_GAMETYPE_SELF', 'Self-play');
define('_MD_CHESS_MENU_GAMETYPE_OPEN', _MD_CHESS_LABEL_GAMETYPE_OPEN . ' - anyone can accept your challenge');
define('_MD_CHESS_MENU_GAMETYPE_USER', _MD_CHESS_LABEL_GAMETYPE_USER . ' - only the specified user can accept your challenge');
define('_MD_CHESS_MENU_GAMETYPE_SELF', _MD_CHESS_LABEL_GAMETYPE_SELF . ' - play against yourself (for learning or testing)');

// opponent
define('_MD_CHESS_LABEL_OPPONENT', 'Opponent');

// FEN setup
define('_MD_CHESS_LABEL_FEN_SETUP', 'FEN setup');
define('_MD_CHESS_LABEL_FEN_EXPLAIN', 'You may optionally provide a board setup position, using FEN (Forsyth-Edwards Notation).  If omitted, the standard board setup will be used.');

// color preference
define('_MD_CHESS_LABEL_COLOR', 'My color will be');
define('_MD_CHESS_RADIO_COLOR_OPPONENT', 'Assigned by my opponent');
define('_MD_CHESS_RADIO_COLOR_RANDOM', 'Assigned randomly');
define('_MD_CHESS_RADIO_COLOR_WHITE', 'White');
define('_MD_CHESS_RADIO_COLOR_BLACK', 'Black');

// notifications
define('_MD_CHESS_NEVT_ACPT_CHAL_CAP', 'Notify me when someone accepts my challenge to a game.');
define('_MD_CHESS_NEVT_MOVE_CAP', 'Notify me when a new move is made in this game.');

// buttons
define('_MD_CHESS_CREATE_SUBMIT', 'Submit');
define('_MD_CHESS_CREATE_ACCEPT', 'Accept');
define('_MD_CHESS_CREATE_CANCEL', 'Cancel');
define('_MD_CHESS_CREATE_DELETE', 'Delete');
define('_MD_CHESS_CONFIRM_DELETE', 'Yes, I am sure I want to delete this');

// errors
define('_MD_CHESS_ERROR', 'Error');
define('_MD_CHESS_GAMETYPE_INVALID', 'Game type not valid');
define('_MD_CHESS_FEN_INVALID', 'FEN setup not valid');
define('_MD_CHESS_OPPONENT_MISSING', 'You must specify the username of your opponent.');
define('_MD_CHESS_OPPONENT_INVALID', 'That opponent is unknown or not available for game play.');
define('_MD_CHESS_OPPONENT_SELF', 'You cannot challenge yourself.');
define('_MD_CHESS_GAME_NOT_FOUND', 'Game not found.');
define('_MD_CHESS_GAME_DELETED', 'Game deleted');
define('_MD_CHESS_WRONG_PLAYER2', 'You may not accept a challenge offered to another user.');
define('_MD_CHESS_SAME_PLAYER2', 'You may not accept a challenge from yourself.');
define('_MD_CHESS_NO_CONFIRM_DELETE', 'You must check the confirmation box');
define('_MD_CHESS_NO_JAVASCRIPT', 'Javascript not enabled. Moves must be made by text entry.');
define('_MD_CHESS_MODHEAD_MISSING', 'WARNING: <{$xoops_module_header}> missing from themes/%s/theme.html.');
define('_MD_CHESS_TOKEN_ERROR', 'Token missing or invalid.');

// templates
define('_MD_CHESS_LABEL_GAMES', 'Games');
define('_MD_CHESS_LABEL_NO_GAMES', 'No games');
define('_MD_CHESS_LABEL_GAME', 'Game');
define('_MD_CHESS_LABEL_CREATED', 'Created');
define('_MD_CHESS_LABEL_LAST_MOVE', 'Last move');
define('_MD_CHESS_LABEL_STATUS', 'Status');
define('_MD_CHESS_LABEL_VS', 'vs.');
define('_MD_CHESS_LABEL_DRAW', 'Draw');
define('_MD_CHESS_LABEL_WHITE_WON', 'White won');
define('_MD_CHESS_LABEL_BLACK_WON', 'Black won');
define('_MD_CHESS_LABEL_WHITE', 'White');
define('_MD_CHESS_LABEL_BLACK', 'Black');
define('_MD_CHESS_LABEL_TO_MOVE', 'to move');
define('_MD_CHESS_LABEL_WHITE_TO_MOVE', 'White to move');
define('_MD_CHESS_LABEL_BLACK_TO_MOVE', 'Black to move');
define('_MD_CHESS_LABEL_CHALLENGES', 'Challenges');
define('_MD_CHESS_LABEL_NO_CHALLENGES', 'No challenges');
define('_MD_CHESS_LABEL_TYPE', 'Type');
define('_MD_CHESS_LABEL_CHALLENGER', 'Challenger');
define('_MD_CHESS_LABEL_COLOR_OPTION', 'Color Option');
define('_MD_CHESS_LABEL_GAME_OVER', 'Game over, score');
define('_MD_CHESS_PGN_FULL', 'Portable Game Notation');
define('_MD_CHESS_PGN_ABBREV', 'PGN');
define('_MD_CHESS_FEN_FULL', 'Forsyth-Edwards Notation');
define('_MD_CHESS_FEN_ABBREV', 'FEN');
define('_MD_CHESS_LABEL_ERROR', '*error*');
define('_MD_CHESS_PROMOTE_TO', 'Promote pawn to');

define('_MD_CHESS_ALT_EMPTY', 'empty square');
define('_MD_CHESS_ALT_WKING', 'white king');
define('_MD_CHESS_ALT_WQUEEN', 'white queen');
define('_MD_CHESS_ALT_WROOK', 'white rook');
define('_MD_CHESS_ALT_WBISHOP', 'white bishop');
define('_MD_CHESS_ALT_WKNIGHT', 'white knight');
define('_MD_CHESS_ALT_WPAWN', 'white pawn');
define('_MD_CHESS_ALT_BKING', 'black king');
define('_MD_CHESS_ALT_BQUEEN', 'black queen');
define('_MD_CHESS_ALT_BROOK', 'black rook');
define('_MD_CHESS_ALT_BBISHOP', 'black bishop');
define('_MD_CHESS_ALT_BKNIGHT', 'black knight');
define('_MD_CHESS_ALT_BPAWN', 'black pawn');

define('_MD_CHESS_CONFIRM', 'Confirm');

define('_MD_CHESS_BUTTON_MOVE', 'Submit');

define('_MD_CHESS_NORMAL_MOVE', 'Normal move');
define('_MD_CHESS_RESIGN', 'Resign');
define('_MD_CHESS_OFFER_DRAW', 'Offer draw');
define('_MD_CHESS_ACCEPT_DRAW', 'Accept draw');
define('_MD_CHESS_REJECT_DRAW', 'Reject draw');
define('_MD_CHESS_CLAIM_DRAW_50', 'Claim draw (50-move rule)');
define('_MD_CHESS_CLAIM_DRAW_3', 'Claim draw (threefold repetition)');
define('_MD_CHESS_RESTART', 'Restart game');
define('_MD_CHESS_DELETE', 'Delete game');
define('_MD_CHESS_WANT_ARBITRATION', 'Request arbitration');
define('_MD_CHESS_MOVE_EXPLAIN', 'Please state reason.');
define('_MD_CHESS_AFTER_MOVE', 'after move');

define('_MD_CHESS_DELETE_WARNING', 'This will permanently remove the game from the database!');

define('_MD_CHESS_BUTTON_REFRESH', 'Refresh');

define('_MD_CHESS_ORIENTATION_ACTIVE', 'Active color at bottom');
define('_MD_CHESS_ORIENTATION_WHITE', 'White at bottom');
define('_MD_CHESS_ORIENTATION_BLACK', 'Black at bottom');

define('_MD_CHESS_ARBITER_CONTROLS', 'Arbiter Controls');
define('_MD_CHESS_ARBITER_SUSPEND', 'Suspend play');
define('_MD_CHESS_ARBITER_RESUME', 'Resume normal play');
define('_MD_CHESS_ARBITER_DRAW', 'Declare draw');
define('_MD_CHESS_ARBITER_EXPLAIN', 'Please state reason.');
define('_MD_CHESS_ARBITER_DELETE', 'Delete game');
define('_MD_CHESS_ARBITER_NOACTION', 'No action');
define('_MD_CHESS_ARBITER_SHOWCTRL', 'Show arbiter controls');

define('_MD_CHESS_ARBITER_DELETE_WARNING', 'This will permanently remove the game from the database!');

define('_MD_CHESS_BUTTON_ARBITRATE', 'Submit');

define('_MD_CHESS_WHEN_SUSPENDED', 'When suspended');
define('_MD_CHESS_SUSPENDED_BY', 'Suspended by');
define('_MD_CHESS_SUSPENSION_TYPE', 'Suspension type');
define('_MD_CHESS_SUSPENSION_REASON', 'Suspension reason');
define('_MD_CHESS_UNKNOWN', '*unknown*');
define('_MD_CHESS_SUSP_TYPE_ARBITER', 'Suspended by arbiter');
define('_MD_CHESS_SUSP_TYPE_PLAYER', 'Arbitration requested');

define('_MD_CHESS_MOVE_ENTRY', 'Move Entry');
define('_MD_CHESS_MOVE_LIST', 'Move List');
define('_MD_CHESS_EXPORT_FORMATS', 'Export');
define('_MD_CHESS_CAPTURED_PIECES', 'Captured Pieces');

// Notifications
define('_MD_CHESS_WHITE', 'White');
define('_MD_CHESS_BLACK', 'Black');
define('_MD_CHESS_RESIGNED', 'resigned.');
define('_MD_CHESS_OFFERED_DRAW', 'offered a draw.');
define('_MD_CHESS_ACCEPTED_DRAW', 'accepted a draw offer.');
define('_MD_CHESS_REJECTED_DRAW', 'rejected a draw offer.');
define('_MD_CHESS_RQSTED_ARBT', 'requested arbitration.');
define('_MD_CHESS_BEEN_SUSPENDED', 'Game suspended pending review by an arbiter.');
define('_MD_CHESS_AS_ARBITER', 'acting as arbiter');
define('_MD_CHESS_RESUMED_PLAY', 'resumed normal play.');
define('_MD_CHESS_DECLARED_DRAW', 'declared a draw.');
define('_MD_CHESS_DELETED_GAME', 'deleted the game.');
define('_MD_CHESS_SUSPENDED_PLAY', '$username (acting as arbiter) suspended play.');

// FEN setup errors
define('_MD_CHESS_FENBAD_LENGTH', 'invalid length');
define('_MD_CHESS_FENBAD_FIELD_COUNT', 'wrong number of fields');
define('_MD_CHESS_FENBAD_PP_INVALID', 'piece placement invalid');
define('_MD_CHESS_FENBAD_AC_INVALID', 'active color invalid');
define('_MD_CHESS_FENBAD_CA_INVALID', 'castling availability invalid');
define('_MD_CHESS_FENBAD_EP_INVALID', 'en passant target_square invalid');
define('_MD_CHESS_FENBAD_HC_INVALID', 'halfmove clock invalid');
define('_MD_CHESS_FENBAD_FN_INVALID', 'fullmove number invalid');
define('_MD_CHESS_FENBAD_MATERIAL', 'insufficient mating material');
define('_MD_CHESS_FENBAD_IN_CHECK', 'player to move cannot have opponent in check');
define('_MD_CHESS_FENBAD_CA_INCONSISTENT', 'castling availability inconsistent with piece placement');
define('_MD_CHESS_FENBAD_EP_COLOR', 'en passant target square wrong color');
define('_MD_CHESS_FENBAD_EP_NO_PAWN', 'en passant target square for nonexistent pawn');

// Move-messages
// Some of these messages are processed with eval() in ChessGame::move_msg(), and may contain parameters $param[1], $param[2], etc.
define('_MD_CHESS_MOVE_UNKNOWN', 'ERROR (autocomplete): format is totally unknown!');
define('_MD_CHESS_MOVE_PAWN_MAY_BECOME', 'ERROR (autocomplete): A pawn may only become either a knight, a bishop, a rook or a queen!');
define('_MD_CHESS_MOVE_USE_X', 'ERROR (autocomplete): use x to indicate an attack');
define('_MD_CHESS_MOVE_COORD_INVALID', 'ERROR (autocomplete): coordinate {$param[1]} is invalid');
define('_MD_CHESS_MOVE_CANNOT_FIND_PAWN', 'ERROR (autocomplete): cannot find {$param[1]} pawn in column {$param[2]}');
define('_MD_CHESS_MOVE_USE_NOTATION', 'ERROR (autocomplete): please use denotation [a-h]x[a-h][1-8] for pawn attacks (see help for more information)');
define('_MD_CHESS_MOVE_NO_PAWN', 'ERROR (autocomplete): there is no pawn in column {$param[1]}');
define('_MD_CHESS_MOVE_TWO_PAWNS', 'ERROR (autocomplete): there is more than one pawn in column {$param[1]}');
define('_MD_CHESS_MOVE_NO_FIGURE', 'ERROR (autocomplete): there is no figure {$param[1]} = {$param[2]}');
define('_MD_CHESS_MOVE_NEITHER_CAN_REACH', 'ERROR (autocomplete): neither of the {$param[1]} = {$param[2]} can reach {$param[3]}');
define('_MD_CHESS_MOVE_BOTH_CAN_REACH', 'ERROR (autocomplete): both of the {$param[1]} = {$param[2]} can reach {$param[3]}');
define('_MD_CHESS_MOVE_AMBIGUOUS', 'ERROR (autocomplete): ambiguity is not properly resolved');
define('_MD_CHESS_MOVE_UNDEFINED', 'ERROR: undefined');
define('_MD_CHESS_MOVE_GAME_OVER', 'ERROR: This game is over. It is not possible to enter any further moves.');
define('_MD_CHESS_MOVE_NO_CASTLE', 'ERROR: You cannot castle.');
define('_MD_CHESS_MOVE_INVALID_PIECE', 'ERROR: only N (knight), B (bishop), R (rook) and Q (queen) are valid chessman identifiers');
define('_MD_CHESS_MOVE_UNKNOWN_FIGURE', 'ERROR: Figure {$param[1]} is unknown!');
define('_MD_CHESS_MOVE_TILE_EMPTY', 'ERROR: Tile {$param[1]} is empty');
define('_MD_CHESS_MOVE_NOT_YOUR_PIECE', 'ERROR: Figure does not belong to you!');
define('_MD_CHESS_MOVE_NOEXIST_FIGURE', 'ERROR: Figure does not exist!');
define('_MD_CHESS_MOVE_START_END_SAME', 'ERROR: Current position and destination are equal!');
define('_MD_CHESS_MOVE_UNKNOWN_ACTION', 'ERROR: {$param[1]} is unknown! Please use "-" for a move and "x" for an attack.');
define('_MD_CHESS_MOVE_OUT_OF_RANGE', 'ERROR: Tile {$param[1]} is out of range for {$param[2]} at {$param[3]}!');
define('_MD_CHESS_MOVE_OCCUPIED', 'ERROR: Tile {$param[1]} is occupied. You cannot move there.');
define('_MD_CHESS_MOVE_NO_EN_PASSANT', 'ERROR: en-passant not possible!');
define('_MD_CHESS_MOVE_ATTACK_EMPTY', 'ERROR: Tile {$param[1]} is empty. You cannot attack it."');
define('_MD_CHESS_MOVE_ATTACK_SELF', 'ERROR: You cannot attack own unit at {$param[1]}.');
define('_MD_CHESS_MOVE_IN_CHECK', 'ERROR: Move is invalid because king would be under attack then.');
define('_MD_CHESS_MOVE_CASTLED_SHORT', 'You castled short.');
define('_MD_CHESS_MOVE_CASTLED_LONG', 'You castled long.');
define('_MD_CHESS_MOVE_MOVED', '{$param[1]} moved from {$param[2]} to {$param[3]}');
define('_MD_CHESS_MOVE_CAPTURED', '{$param[1]} captured {$param[2]} from {$param[3]}');
define('_MD_CHESS_MOVE_PROMOTED', 'and became a {$param[1]}!');
define('_MD_CHESS_MOVE_CHECKMATE', 'checkmate!');
define('_MD_CHESS_MOVE_STALEMATE', 'stalemate!');
define('_MD_CHESS_MOVE_MATERIAL', 'insufficient mating material!');
define('_MD_CHESS_MOVE_KING', 'king');
define('_MD_CHESS_MOVE_QUEEN', 'queen');
define('_MD_CHESS_MOVE_ROOK', 'rook');
define('_MD_CHESS_MOVE_BISHOP', 'bishop');
define('_MD_CHESS_MOVE_KNIGHT', 'knight');
define('_MD_CHESS_MOVE_PAWN', 'pawn');
define('_MD_CHESS_MOVE_EMPTY', 'empty');

// miscellaneous
define('_MD_CHESS_GAME_CONFIRM', 'Confirm your game preferences');
define('_MD_CHESS_GAME_CREATED', 'Game created');
define('_MD_CHESS_GAME_STARTED', 'Game started');
define('_MD_CHESS_LABEL_DATE_CREATED', 'Date created');
define('_MD_CHESS_LABEL_GAME_SUSPENDED', 'Game suspended');
define('_MD_CHESS_WHITE_OFFERED_DRAW', 'White has offered a draw. Black must either accept or reject the offer.');
define('_MD_CHESS_BLACK_OFFERED_DRAW', 'Black has offered a draw. White must either accept or reject the offer.');

// PGN movetext comments for drawn games - must not contain comment delimiters '{' or '}'
define('_MD_CHESS_DRAW_STALEMATE', 'Drawn by stalemate.');
define('_MD_CHESS_DRAW_NO_MATE', 'Drawn since no checkmate is possible.');
define('_MD_CHESS_DRAW_BY_AGREEMENT', 'Drawn by mutual agreement.');
define('_MD_CHESS_DRAW_DECLARED', 'Draw declared by arbiter, reason: %s.');
define('_MD_CHESS_DRAW_50', 'Drawn by 50-move rule.');
define('_MD_CHESS_DRAW_3', 'Drawn by threefold-repetition rule, based on board position immediately prior to moves %s.');

define('_MD_CHESS_NO_DRAW_50', 'The conditions for claiming a draw under the 50-move rule have not been satisfied.');
define('_MD_CHESS_NO_DRAW_3', 'The conditions for claiming a draw under the threefold-repetition rule have not been satisfied.');

// menu options
define('_MD_CHESS_SHOW_GAMES_INPLAY', 'Show games in play only');
define('_MD_CHESS_SHOW_GAMES_CONCLUDED', 'Show concluded games only');
define('_MD_CHESS_SHOW_GAMES_BOTH', 'Show all games');
define('_MD_CHESS_SHOW_GAMES_RATED', 'Show rated games only');
define('_MD_CHESS_SHOW_GAMES_UNRATED', 'Show rated and unrated games');
define('_MD_CHESS_SHOW_CHALLENGES_OPEN', 'Show open challenges only');
define('_MD_CHESS_SHOW_CHALLENGES_USER', 'Show individual challenges only');
define('_MD_CHESS_SHOW_CHALLENGES_BOTH', 'Show all challenges');

// ratings
define('_MD_CHESS_RATED_GAME', 'Rated game');
define('_MD_CHESS_RATINGS_OFF', 'Rating feature not enabled.');
define('_MD_CHESS_PLAYER_RATINGS', 'Chess Player Ratings');
define('_MD_CHESS_RATING', 'Rating');
define('_MD_CHESS_PLAYER', 'Player');
define('_MD_CHESS_GAMES_PLAYED', 'Rated games played');
define('_MD_CHESS_PROVISIONAL', 'Provisional rating (less than %s rated games played)');
define('_MD_CHESS_NA', 'n/a'); // not applicable or not available
define('_MD_CHESS_NO_RATING_INFO', 'No rating information found.');
define('_MD_CHESS_RECALC_RATINGS', 'Recalculate all player ratings (available only to module administrators)');
define('_MD_CHESS_SUBMIT_BUTTON', 'Submit');
define('_MD_CHESS_RECALC_CONFIRM', 'Yes, I am sure I want to do this.');
define('_MD_CHESS_RECALC_DONE', 'Ratings recalculated.');
define('_MD_CHESS_RECALC_NOT_DONE', 'Ratings not recalculated because confirmation box was not checked.');
define('_MD_CHESS_LAST_ACTIVITY', 'Last activity');
define('_MD_CHESS_STATUS', 'Status');
define('_MD_CHESS_DRAWN', 'drawn');
define('_MD_CHESS_WON', 'won');
define('_MD_CHESS_LOST', 'lost');
define('_MD_CHESS_RANKED', 'Ranked');
define('_MD_CHESS_RATED_GAMES_PLAYED', 'Rated games played');
define('_MD_CHESS_CHALLENGES_FOR', 'Chess challenges for: %s');
define('_MD_CHESS_GAMES_FOR', 'Chess games for: %s');
define('_MD_CHESS_STATS_FOR', 'Chess stats for: %s');
define('_MD_CHESS_SELECT_PLAYER', 'Select player and display option');
define('_MD_CHESS_USERNAME', 'Username');
define('_MD_CHESS_SHOW_ALL_GAMES', 'Show all games');
define('_MD_CHESS_SHOW_EXCEPT_SELFPLAY', 'Show all games except self-play');
define('_MD_CHESS_SHOW_RATED_ONLY', 'Show rated games only');
define('_MD_CHESS_PLAYER_NOT_FOUND', 'No game information found for player.');
define('_MD_CHESS_VIEW_PROFILE', 'View player\'s profile');
