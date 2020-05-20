<?php

// Main
define('_MI_CHESS',     'Chess');
define('_MI_CHESS_DES', 'Allows users to play chess games against each other.');

// Blocks
define('_MI_CHESS_GAMES',          'Recent chess games');
define('_MI_CHESS_GAMES_DES',      'List of recent games');
define('_MI_CHESS_CHALLENGES',     'Recent chess challenges');
define('_MI_CHESS_CHALLENGES_DES', 'List of recent challenges');

// Templates
define('_MI_CHESS_INDEX',         'Chess index page');
define('_MI_CHESS_GAME',          'Chess game');
define('_MI_CHESS_MOVE_FORM',     'Chess move form');
define('_MI_CHESS_PROMOTE_POPUP', 'Chess pawn promotion popup');
define('_MI_CHESS_BOARD',         'Chess board');
define('_MI_CHESS_PREFS_FORM',    'Chess preferences form');
define('_MI_CHESS_ARBITER_FORM',  'Chess arbitrate form');
define('_MI_CHESS_HELP',          'Chess help');

// Menu
define('_MI_CHESS_SMNAME1', 'Help');
define('_MI_CHESS_SMNAME2', 'List games');
define('_MI_CHESS_SMNAME3', 'Create new game');

// Config
define('_MI_CHESS_GROUPS_PLAY',       'Play-chess right');
define('_MI_CHESS_GROUPS_PLAY_DES',   'A user in any of the selected groups can challenge other users to games, accept game challenges from other users, and create self-play games.');
define('_MI_CHESS_GROUPS_DELETE',     'Delete-game right');
define('_MI_CHESS_GROUPS_DELETE_DES', 'A user in any of the selected groups can delete a game in which he is playing. Regardless of whether he has this right, a player may delete a self-play game.');
define('_MI_CHESS_ALLOW_SETUP',       'Allow board setups?');
define('_MI_CHESS_ALLOW_SETUP_DES',   'When creating a game, may a user provide an initial board setup position using Forsyth-Edwards Notation (FEN)?');

// Notifications

define('_MI_CHESS_NCAT_GAME',           'Game');
define('_MI_CHESS_NCAT_GAME_DES',       'This is the game category.');

define('_MI_CHESS_NCAT_GLOBAL',         'Global');
define('_MI_CHESS_NCAT_GLOBAL_DES',     'This is the chess category.');

define('_MI_CHESS_NEVT_MOVE',           'New move');
define('_MI_CHESS_NEVT_MOVE_CAP',       'Notify me when a new move is made in this game.');
define('_MI_CHESS_NEVT_MOVE_DES',       'New move description - is this text used anywhere?');
define('_MI_CHESS_NEVT_MOVE_SUB',       '[{X_SITENAME}] {X_MODULE} auto-notify : New move');

define('_MI_CHESS_NEVT_CHAL_USER',      'Individual challenge');
define('_MI_CHESS_NEVT_CHAL_USER_CAP',  'Notify me when someone challenges me to a game.');
define('_MI_CHESS_NEVT_CHAL_USER_DES',  '');
define('_MI_CHESS_NEVT_CHAL_USER_SUB',  '[{X_SITENAME}] {X_MODULE} auto-notify : Individual challenge');

define('_MI_CHESS_NEVT_CHAL_OPEN',      'Open challenge');
define('_MI_CHESS_NEVT_CHAL_OPEN_CAP',  'Notify me when a new open-challenge game is created.');
define('_MI_CHESS_NEVT_CHAL_OPEN_DES',  '');
define('_MI_CHESS_NEVT_CHAL_OPEN_SUB',  '[{X_SITENAME}] {X_MODULE} auto-notify : Open challenge');

define('_MI_CHESS_NEVT_ACPT_CHAL',      'Challenge accepted');
define('_MI_CHESS_NEVT_ACPT_CHAL_CAP',  'Notify me when someone accepts my challenge to a game.');
define('_MI_CHESS_NEVT_ACPT_CHAL_DES',  '');
define('_MI_CHESS_NEVT_ACPT_CHAL_SUB',  '[{X_SITENAME}] {X_MODULE} auto-notify : Your challenge accepted');

define('_MI_CHESS_NEVT_RQST_ARBT',      'Arbitration requested (admin-only)');
define('_MI_CHESS_NEVT_RQST_ARBT_CAP',  'Notify me when arbitration is requested (admin-only).');
define('_MI_CHESS_NEVT_RQST_ARBT_DES',  '');
define('_MI_CHESS_NEVT_RQST_ARBT_SUB',  '[{X_SITENAME}] {X_MODULE} auto-notify : Arbitration requested');

// Admin menu items
define('_MI_CHESS_ADMENU1', 'Suspended games');
define('_MI_CHESS_ADMENU2', 'Active games');
define('_MI_CHESS_ADMENU3', 'Challenges');

?>
