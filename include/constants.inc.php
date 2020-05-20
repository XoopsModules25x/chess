<?php

/**
 * Constants
 *
 * @package chess
 * @subpackage constants
 */

/**#@+
 * must match database column values for chess_challenges.game_type
 */
define('_CHESS_GAMETYPE_OPEN', 'open');
define('_CHESS_GAMETYPE_USER', 'user');
define('_CHESS_GAMETYPE_SELF', 'self');
/**#@-*/

/**#@+
 * HTML form textbox attribute
 */
define('_CHESS_TEXTBOX_OPPONENT_SIZE', 32);
define('_CHESS_TEXTBOX_OPPONENT_MAXLEN', 32);
define('_CHESS_TEXTBOX_FEN_MAXLEN', 100);
define('_CHESS_TEXTBOX_EXPLAIN_MAXLEN', 100);
/**#@-*/

/**#@+
 * must match database column values for chess_challenges.color_option
 */
define('_CHESS_COLOROPTION_OPPONENT', 'player2');
define('_CHESS_COLOROPTION_RANDOM', 'random');
define('_CHESS_COLOROPTION_WHITE', 'white');
define('_CHESS_COLOROPTION_BLACK', 'black');
/**#@-*/

/**#@+
 * move type
 */
define('_CHESS_MOVETYPE_NORMAL', 'normal');
define('_CHESS_MOVETYPE_RESIGN', 'resign');
define('_CHESS_MOVETYPE_OFFER_DRAW', 'offer_draw');
define('_CHESS_MOVETYPE_ACCEPT_DRAW', 'accept_draw');
define('_CHESS_MOVETYPE_REJECT_DRAW', 'reject_draw');
define('_CHESS_MOVETYPE_RESTART', 'restart');
define('_CHESS_MOVETYPE_DELETE', 'delete');
define('_CHESS_MOVETYPE_CLAIM_DRAW_50', 'claim_draw_50');
define('_CHESS_MOVETYPE_CLAIM_DRAW_3', 'claim_draw_3');
define('_CHESS_MOVETYPE_WANT_ARBITRATION', 'want_arbitration');
define('_CHESS_MOVETYPE_ARBITER_SUSPEND', 'arbiter_suspend');
/**#@-*/

/**#@+
 * must match database column values for chess_games.board_orientation
 */
define('_CHESS_ORIENTATION_ACTIVE', 'active');
define('_CHESS_ORIENTATION_WHITE', 'white');
define('_CHESS_ORIENTATION_BLACK', 'black');
/**#@-*/

/**#@+
 * arbiter action
 */
define('_CHESS_ARBITER_SUSPEND', 'suspend');
define('_CHESS_ARBITER_RESUME', 'resume');
define('_CHESS_ARBITER_DRAW', 'draw');
define('_CHESS_ARBITER_DELETE', 'delete');
define('_CHESS_ARBITER_NOACTION', 'no_action');
/**#@-*/

/**
 * regex character class of characters allowed in usernames
 */
define('_CHESS_USERNAME_ALLOWED_CHARACTERS', 'A-Za-z0-9 .-');

/**#@+
 * number of seconds to display a form-submit message
 */
define('_CHESS_REDIRECT_DELAY_FAILURE', 5); // action failed
define('_CHESS_REDIRECT_DELAY_SUCCESS', 1); // action succeeded

/**#@+
 * menu option for filtering challenges: open/individual/all
 */
define('_CHESS_SHOW_CHALLENGES_OPEN', 1);
define('_CHESS_SHOW_CHALLENGES_USER', 2);
define('_CHESS_SHOW_CHALLENGES_BOTH', 3);
/**#@-*/

/**#@+
 * menu option for filtering games - in-play/concluded/all
 */
define('_CHESS_SHOW_GAMES_INPLAY', 1);
define('_CHESS_SHOW_GAMES_CONCLUDED', 2);
define('_CHESS_SHOW_GAMES_BOTH', 3);
/**#@-*/

/**#@+
 * menu option for filtering games - rated-only/rated-and-unrated
 */
define('_CHESS_SHOW_GAMES_RATED', 1);
define('_CHESS_SHOW_GAMES_UNRATED', 2);
/**#@-*/

/**#@+
 * menu option for filtering games and challenges: all/all-except-selfplay/rated-only
 */
define('_CHESS_SHOW_ALL_GAMES', 1);
define('_CHESS_SHOW_EXCEPT_SELFPLAY', 2);
define('_CHESS_SHOW_RATED_ONLY', 3);
/**#@-*/
