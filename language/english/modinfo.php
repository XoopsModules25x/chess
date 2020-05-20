<?php declare(strict_types=1);

/**
 * Language strings for module initialization (en)
 *
 * @package chess
 * @subpackage language
 */

/**#@+
 * @ignore
 */

// Warning: Some of the these constant values contain the sprintf format code "%s".  That format code must not be removed.

// Main
define('_MI_CHESS', 'Chess');
define('_MI_CHESS_DES', 'Allows users to play chess games against each other.');
define('_MI_CHESS_CREDITS', '
	Jacques Masscrier and Pierre Fran篩s Gagnon (french language pack).
	<br>
	CXR Rating System used by permission of <a target="_blank" href="http://chess-express.com/">Chess Express Ratings, Inc.</a>
');
define('_MI_CHESS_NAME', 'Chess');

// Blocks
define('_MI_CHESS_GAMES', 'Recent chess games');
define('_MI_CHESS_GAMES_DES', 'List of recent games');
define('_MI_CHESS_CHALLENGES', 'Recent chess challenges');
define('_MI_CHESS_CHALLENGES_DES', 'List of recent challenges');
define('_MI_CHESS_PLAYERS', 'Highest-rated chess players');
define('_MI_CHESS_PLAYERS_DES', 'List of highest-rated chess players');

// Templates
define('_MI_CHESS_INDEX', 'Chess index page');
define('_MI_CHESS_GAME', 'Chess game');
define('_MI_CHESS_MOVE_FORM', 'Chess move form');
define('_MI_CHESS_PROMOTE_POPUP', 'Chess pawn promotion popup');
define('_MI_CHESS_BOARD', 'Chess board');
define('_MI_CHESS_PREFS_FORM', 'Chess preferences form');
define('_MI_CHESS_ARBITER_FORM', 'Chess arbitrate form');
define('_MI_CHESS_HELP', 'Chess help');
define('_MI_CHESS_RATINGS', 'Chess player ratings (all players)');
define('_MI_CHESS_PLAYER_STATS', 'Chess player statistics (individual player)');

// Menu
define('_MI_CHESS_SMNAME1', 'Help');
define('_MI_CHESS_SMNAME2', 'List games');
define('_MI_CHESS_SMNAME3', 'Create new game');
define('_MI_CHESS_SMNAME4', 'Player ratings');
define('_MI_CHESS_SMNAME5', 'My games');

// Rating systems (used in config)
define('_MI_CHESS_RATING_SYSTEM_NONE', 'None');
define('_MI_CHESS_RATING_SYSTEM_CXR', 'CXR');
define('_MI_CHESS_RATING_SYSTEM_LINEAR', 'Linear');

// Config
define('_MI_CHESS_GROUPS_PLAY', 'Play-chess right');
define('_MI_CHESS_GROUPS_PLAY_DES', 'A user in any of the selected groups can challenge other users to games, accept game challenges from other users, and create self-play games.');
define('_MI_CHESS_GROUPS_DELETE', 'Delete-game right');
define('_MI_CHESS_GROUPS_DELETE_DES', 'A user in any of the selected groups can delete a game in which he is playing. Regardless of whether he has this right, a player may delete a self-play game.');
define('_MI_CHESS_ALLOW_SETUP', 'Allow board setups?');
define('_MI_CHESS_ALLOW_SETUP_DES', 'When creating a game, may a user provide an initial board setup position using Forsyth-Edwards Notation (FEN)?');
define('_MI_CHESS_MAX_ITEMS', 'Maximum number of items to display on a page');
define('_MI_CHESS_MAX_ITEMS_DES', 'Applies to games, challenges and players.');
define('_MI_CHESS_RATING_SYSTEM', 'Player rating system');
define('_MI_CHESS_RATING_SYSTEM_DES', '
	Available rating systems:
	<br><br>
	&nbsp;&nbsp;' . _MI_CHESS_RATING_SYSTEM_CXR . '    - Adaptation of the ELO rating system, used by permission of <a target="_blank" href="http://chess-express.com/">Chess Express Ratings, Inc.</a>
	<br><br>
	&nbsp;&nbsp;' . _MI_CHESS_RATING_SYSTEM_LINEAR . ' - A very simple system that adds (subtracts) a fixed number of points for a win (loss).
	<br><br>
	Select "' . _MI_CHESS_RATING_SYSTEM_NONE . '" to disable the rating feature.
	<br><br>
	After changing this setting, you should rebuild the player ratings data from Main Menu >> Chess >>
	' . _MI_CHESS_SMNAME4 . '.
');
define('_MI_CHESS_INITIAL_RATING', 'Initial player rating');
define('_MI_CHESS_INITIAL_RATING_DES', '
	If the "' . _MI_CHESS_RATING_SYSTEM_CXR . '" rating system is selected, this value should be between 800 and 2000.
	<br><br>
	Applies only if a player rating system is selected.
	<br><br>
	If you change this value, you should rebuild the player ratings data from Main Menu >> Chess >> ' . _MI_CHESS_SMNAME4 . '.
');
define('_MI_CHESS_ALLOW_UNRATED', 'Allow unrated games?');
define('_MI_CHESS_ALLOW_UNRATED_DES', '
	When offering a challenge, may the player exclude the game from use in rating calculations?
	<br><br>
	Applies only if a player rating system is selected.
');

// Notifications

define('_MI_CHESS_NCAT_GAME', 'Game');
define('_MI_CHESS_NCAT_GAME_DES', 'This is the game category.');

define('_MI_CHESS_NCAT_GLOBAL', 'Global');
define('_MI_CHESS_NCAT_GLOBAL_DES', 'This is the chess category.');

define('_MI_CHESS_NEVT_MOVE', 'New move');
define('_MI_CHESS_NEVT_MOVE_CAP', 'Notify me when a new move is made in this game.');
define('_MI_CHESS_NEVT_MOVE_DES', 'New move description - is this text used anywhere?');
define('_MI_CHESS_NEVT_MOVE_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : New move');

define('_MI_CHESS_NEVT_CHAL_USER', 'Individual challenge');
define('_MI_CHESS_NEVT_CHAL_USER_CAP', 'Notify me when someone challenges me to a game.');
define('_MI_CHESS_NEVT_CHAL_USER_DES', '');
define('_MI_CHESS_NEVT_CHAL_USER_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : Individual challenge');

define('_MI_CHESS_NEVT_CHAL_OPEN', 'Open challenge');
define('_MI_CHESS_NEVT_CHAL_OPEN_CAP', 'Notify me when a new open-challenge game is created.');
define('_MI_CHESS_NEVT_CHAL_OPEN_DES', '');
define('_MI_CHESS_NEVT_CHAL_OPEN_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : Open challenge');

define('_MI_CHESS_NEVT_ACPT_CHAL', 'Challenge accepted');
define('_MI_CHESS_NEVT_ACPT_CHAL_CAP', 'Notify me when someone accepts my challenge to a game.');
define('_MI_CHESS_NEVT_ACPT_CHAL_DES', '');
define('_MI_CHESS_NEVT_ACPT_CHAL_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : Your challenge accepted');

define('_MI_CHESS_NEVT_RQST_ARBT', 'Arbitration requested (admin-only)');
define('_MI_CHESS_NEVT_RQST_ARBT_CAP', 'Notify me when arbitration is requested (admin-only).');
define('_MI_CHESS_NEVT_RQST_ARBT_DES', '');
define('_MI_CHESS_NEVT_RQST_ARBT_SUB', '[{X_SITENAME}] {X_MODULE} auto-notify : Arbitration requested');

// Admin menu items
define('_MI_CHESS_ADMENU1', 'Suspended games');
define('_MI_CHESS_ADMENU2', 'Active games');
define('_MI_CHESS_ADMENU3', 'Challenges');
//Menu
define('_MI_CHESS_MENU_HOME', 'Home');
define('_MI_CHESS_MENU_ABOUT', 'About');

// Install/upgrade
define('_MI_CHESS_OLD_VERSION', 'Direct update not supported from version "%s".  Please see the file "%s".');
define('_MI_CHESS_RATINGS_TABLE_1', 'Checking that "%s" table does not already exist ...');
define('_MI_CHESS_RATINGS_TABLE_2', ' ... Failed to check existence of table "%s": (%s) %s');
define('_MI_CHESS_RATINGS_TABLE_3', ' ... The table "%s" already exists, indicating that this update has already been performed.');
define('_MI_CHESS_OK', ' ... Ok');
define('_MI_CHESS_CHK_DB_TABLES', 'Checking database tables ...');
define('_MI_CHESS_GAMES_TABLE_1', 'Examining "%s" table prior to altering it ...');
define('_MI_CHESS_GAMES_TABLE_2', ' ... Failed to examine table "%s": (%s) %s');
define('_MI_CHESS_GAMES_TABLE_3', ' ... The "%s" column of the "%s" table must contain only these values: %s.');
define('_MI_CHESS_GAMES_TABLE_4', ' ... Please correct the table, and then perform this update again.');
define('_MI_CHESS_UPDATING_DATABASE', 'Updating database tables ...');
define('_MI_CHESS_INIT_RATINGS_TABLE', 'Initializing ratings table ...');
define('_MI_CHESS_UPDATE_SUCCESSFUL', 'Update successful.');

//2.01

//Config
define('MI_CHESS_EDITOR_ADMIN', 'Editor: Admin');
define('MI_CHESS_EDITOR_ADMIN_DESC', 'Select the Editor to use by the Admin');
define('MI_CHESS_EDITOR_USER', 'Editor: User');
define('MI_CHESS_EDITOR_USER_DESC', 'Select the Editor to use by the User');

//Help
define('_MI_CHESS_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_CHESS_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_CHESS_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_CHESS_OVERVIEW', 'Overview');

//define('_MI_CHESS_HELP_DIR', __DIR__);

//help multi-page
define('_MI_CHESS_DISCLAIMER', 'Disclaimer');
define('_MI_CHESS_LICENSE', 'License');
define('_MI_CHESS_SUPPORT', 'Support');
