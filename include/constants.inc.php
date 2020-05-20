<?php

// values must match database column values for chess_challenges.game_type
define('_CHESS_GAMETYPE_OPEN', 'open');
define('_CHESS_GAMETYPE_USER', 'user');
define('_CHESS_GAMETYPE_SELF', 'self');

define('_CHESS_TEXTBOX_OPPONENT_SIZE',   32);
define('_CHESS_TEXTBOX_OPPONENT_MAXLEN', 32);

define('_CHESS_TEXTBOX_FEN_MAXLEN', 100);
define('_CHESS_TEXTBOX_EXPLAIN_MAXLEN', 100);

// values must match database column values for chess_challenges.color_option
define('_CHESS_COLOROPTION_OPPONENT', 'player2');
define('_CHESS_COLOROPTION_RANDOM',   'random');
define('_CHESS_COLOROPTION_WHITE',    'white');
define('_CHESS_COLOROPTION_BLACK',    'black');

define('_CHESS_MOVETYPE_NORMAL',           'normal');
define('_CHESS_MOVETYPE_RESIGN',           'resign');
define('_CHESS_MOVETYPE_OFFER_DRAW',       'offer_draw');
define('_CHESS_MOVETYPE_ACCEPT_DRAW',      'accept_draw');
define('_CHESS_MOVETYPE_REJECT_DRAW',      'reject_draw');
define('_CHESS_MOVETYPE_RESTART',          'restart');
define('_CHESS_MOVETYPE_DELETE',           'delete');
define('_CHESS_MOVETYPE_CLAIM_DRAW_50',    'claim_draw_50');
define('_CHESS_MOVETYPE_CLAIM_DRAW_3',     'claim_draw_3');
define('_CHESS_MOVETYPE_WANT_ARBITRATION', 'want_arbitration');

define('_CHESS_MOVETYPE_ARBITER_SUSPEND',  'arbiter_suspend');

// values must match database column values for chess_games.board_orientation
define('_CHESS_ORIENTATION_ACTIVE', 'active');
define('_CHESS_ORIENTATION_WHITE',  'white');
define('_CHESS_ORIENTATION_BLACK',  'black');

define('_CHESS_ARBITER_SUSPEND',   'suspend');
define('_CHESS_ARBITER_RESUME',    'resume');
define('_CHESS_ARBITER_DRAW',      'draw');
#define('_CHESS_ARBITER_DRAW_TEST', 'draw_test');#*#TBD# - not used
define('_CHESS_ARBITER_DELETE',    'delete');
define('_CHESS_ARBITER_NOACTION',  'no_action');

// regex character class of characters allowed in usernames
define('_CHESS_USERNAME_ALLOWED_CHARACTERS', 'A-Za-z0-9 .-');

// number of seconds to display a form-submit message
define('_CHESS_REDIRECT_DELAY_FAILURE', 5); // action failed
define('_CHESS_REDIRECT_DELAY_SUCCESS', 1); // action succeeded
?>
