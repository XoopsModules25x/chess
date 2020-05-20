<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

/**
 * Module configuration data
 *
 * @package chess
 * @subpackage miscellaneous
 */

// Main Info
$modversion['name']        = _MI_CHESS;
$modversion['version']     = 1.07;
$modversion['description'] = _MI_CHESS_DES;
$modversion['credits']     = _MI_CHESS_CREDITS;
$modversion['author']      = '<a target="_blank" href="http://Dave-L.com/">Dave Lerner</a>';
$modversion['help']        = 'help.html';
$modversion['license']     = 'GPL see LICENSE';
$modversion['official']    = 0;
$modversion['image']       = 'images/chess_slogo.png';
$modversion['dirname']     = 'chess';

// Install/upgrade
$modversion['onUpdate'] = 'include/install.inc.php';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0]        = 'chess_games';
$modversion['tables'][1]        = 'chess_challenges';
$modversion['tables'][2]        = 'chess_ratings';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Config

$modversion['config'][1]['name']        = 'groups_play';
$modversion['config'][1]['title']       = '_MI_CHESS_GROUPS_PLAY';
$modversion['config'][1]['description'] = '_MI_CHESS_GROUPS_PLAY_DES';
$modversion['config'][1]['formtype']    = 'group_multi';
$modversion['config'][1]['valuetype']   = 'array';
$modversion['config'][1]['default']     = array(XOOPS_GROUP_ADMIN, XOOPS_GROUP_USERS);

$modversion['config'][2]['name']        = 'groups_delete';
$modversion['config'][2]['title']       = '_MI_CHESS_GROUPS_DELETE';
$modversion['config'][2]['description'] = '_MI_CHESS_GROUPS_DELETE_DES';
$modversion['config'][2]['formtype']    = 'group_multi';
$modversion['config'][2]['valuetype']   = 'array';
$modversion['config'][2]['default']     = array();

$modversion['config'][3]['name']        = 'allow_setup';
$modversion['config'][3]['title']       = '_MI_CHESS_ALLOW_SETUP';
$modversion['config'][3]['description'] = '_MI_CHESS_ALLOW_SETUP_DES';
$modversion['config'][3]['formtype']    = 'yesno';
$modversion['config'][3]['valuetype']   = 'int';
$modversion['config'][3]['default']     = 0;

$modversion['config'][4]['name']        = 'max_items';
$modversion['config'][4]['title']       = '_MI_CHESS_MAX_ITEMS';
$modversion['config'][4]['description'] = '_MI_CHESS_MAX_ITEMS_DES';
$modversion['config'][4]['formtype']    = 'textbox';
$modversion['config'][4]['valuetype']   = 'int';
$modversion['config'][4]['default']     = 10;

$modversion['config'][5]['name']        = 'rating_system';
$modversion['config'][5]['title']       = '_MI_CHESS_RATING_SYSTEM';
$modversion['config'][5]['description'] = '_MI_CHESS_RATING_SYSTEM_DES';
$modversion['config'][5]['formtype']    = 'select';
$modversion['config'][5]['valuetype']   = 'text';
$modversion['config'][5]['options']     = array(
	_MI_CHESS_RATING_SYSTEM_NONE   => 'none',
	_MI_CHESS_RATING_SYSTEM_CXR    => 'cxr',
	_MI_CHESS_RATING_SYSTEM_LINEAR => 'linear',
);
$modversion['config'][5]['default']     = 'cxr';

$modversion['config'][6]['name']        = 'initial_rating';
$modversion['config'][6]['title']       = '_MI_CHESS_INITIAL_RATING';
$modversion['config'][6]['description'] = '_MI_CHESS_INITIAL_RATING_DES';
$modversion['config'][6]['formtype']    = 'textbox';
$modversion['config'][6]['valuetype']   = 'int';
$modversion['config'][6]['default']     = 1200;

$modversion['config'][7]['name']        = 'allow_unrated_games';
$modversion['config'][7]['title']       = '_MI_CHESS_ALLOW_UNRATED';
$modversion['config'][7]['description'] = '_MI_CHESS_ALLOW_UNRATED_DES';
$modversion['config'][7]['formtype']    = 'yesno';
$modversion['config'][7]['valuetype']   = 'int';
$modversion['config'][7]['default']     = 1;

// Menu
$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _MI_CHESS_SMNAME1;
$modversion['sub'][1]['url']  = 'help.php';

$modversion['sub'][2]['name'] = _MI_CHESS_SMNAME2;
$modversion['sub'][2]['url']  = 'index.php';

// Conditional menu items
global $xoopsModule, $xoopsModuleConfig, $xoopsUser;
if (is_object($xoopsModule) and $xoopsModule->getVar('dirname') == 'chess') {

// Display create-game menu item if current user has the play-chess right.
	if (!empty($xoopsModuleConfig['groups_play']) and is_array($xoopsModuleConfig['groups_play'])
		and (
			in_array(XOOPS_GROUP_ANONYMOUS, $xoopsModuleConfig['groups_play'])
			or (
				is_object($xoopsUser) and count(array_intersect($xoopsUser->getGroups(), $xoopsModuleConfig['groups_play'])) > 0
			)
		)
	)
	{
		$modversion['sub'][3]['name'] = _MI_CHESS_SMNAME3;
		$modversion['sub'][3]['url']  = 'create.php';
	}

// Display ratings menu item if ratings system is enabled.
	if ($xoopsModuleConfig['rating_system'] != 'none') {
		$modversion['sub'][4]['name'] = _MI_CHESS_SMNAME4;
		$modversion['sub'][4]['url']  = 'ratings.php';
	}

// Display my-games menu item if current user is logged in.
	if (is_object($xoopsUser)) {
		$modversion['sub'][5]['name'] = _MI_CHESS_SMNAME5;
		$modversion['sub'][5]['url']  = 'player_stats.php?player_uid=' . $xoopsUser->getVar('uid');
	}
}

// Page Awareness
$modversion['pages'][1]['name'] = _MI_CHESS_SMNAME1;
$modversion['pages'][1]['url'] = "help.php";
$modversion['pages'][2]['name'] = _MI_CHESS_SMNAME2;
$modversion['pages'][2]['url'] = "index.php";
$modversion['pages'][3]['name'] = _MI_CHESS_SMNAME3;
$modversion['pages'][3]['url'] = "create.php";
$modversion['pages'][4]['name'] = _MI_CHESS_SMNAME4;
$modversion['pages'][4]['url'] = "ratings.php";
$modversion['pages'][5]['name'] = _MI_CHESS_SMNAME5;
$modversion['pages'][5]['url'] = "player_stats.php";

// Templates
$modversion['templates'][ 1]['file']        = 'chess_games.html';
$modversion['templates'][ 1]['description'] = _MI_CHESS_INDEX;
$modversion['templates'][ 2]['file']        = 'chess_game_main.html';
$modversion['templates'][ 2]['description'] = _MI_CHESS_GAME;
$modversion['templates'][ 3]['file']        = 'chess_game_moveform.html';
$modversion['templates'][ 3]['description'] = _MI_CHESS_MOVE_FORM;
$modversion['templates'][ 4]['file']        = 'chess_game_promote_popup.html';
$modversion['templates'][ 4]['description'] = _MI_CHESS_PROMOTE_POPUP;
$modversion['templates'][ 5]['file']        = 'chess_game_board.html';
$modversion['templates'][ 5]['description'] = _MI_CHESS_BOARD;
$modversion['templates'][ 6]['file']        = 'chess_game_prefsform.html';
$modversion['templates'][ 6]['description'] = _MI_CHESS_PREFS_FORM;
$modversion['templates'][ 7]['file']        = 'chess_game_arbitrateform.html';
$modversion['templates'][ 7]['description'] = _MI_CHESS_ARBITER_FORM;
$modversion['templates'][ 8]['file']        = 'chess_help.html';
$modversion['templates'][ 8]['description'] = _MI_CHESS_HELP;
$modversion['templates'][ 9]['file']        = 'chess_ratings.html';
$modversion['templates'][ 9]['description'] = _MI_CHESS_RATINGS;
$modversion['templates'][10]['file']        = 'chess_player_stats.html';
$modversion['templates'][10]['description'] = _MI_CHESS_PLAYER_STATS;

// Blocks
$modversion['blocks'][1]['file']        = 'blocks.php';
$modversion['blocks'][1]['name']        = _MI_CHESS_GAMES;
$modversion['blocks'][1]['description'] = _MI_CHESS_GAMES_DES;
$modversion['blocks'][1]['show_func']   = 'b_chess_games_show';
// options: maximum number of games to display | 1=show games in play only/2=show concluded games only/3=show both | 1=show rated games only/2=show rated and unrated games
$modversion['blocks'][1]['options']     = '4|3|2';
$modversion['blocks'][1]['edit_func']   = 'b_chess_games_edit';
$modversion['blocks'][1]['template']    = 'chess_block_games.html';

$modversion['blocks'][2]['file']        = 'blocks.php';
$modversion['blocks'][2]['name']        = _MI_CHESS_CHALLENGES;
$modversion['blocks'][2]['description'] = _MI_CHESS_CHALLENGES_DES;
$modversion['blocks'][2]['show_func']   = 'b_chess_challenges_show';
// options: maximum number of challenges to display | 1=show open challenges only/2=show individual challenges only/3=show both
$modversion['blocks'][2]['options']     = '4|3';
$modversion['blocks'][2]['edit_func']   = 'b_chess_challenges_edit';
$modversion['blocks'][2]['template']    = 'chess_block_challenges.html';

$modversion['blocks'][3]['file']        = 'blocks.php';
$modversion['blocks'][3]['name']        = _MI_CHESS_PLAYERS;
$modversion['blocks'][3]['description'] = _MI_CHESS_PLAYERS_DES;
$modversion['blocks'][3]['show_func']   = 'b_chess_players_show';
// options: maximum number of players to display | 1=show non-provisional ratings only/2=show all ratings
$modversion['blocks'][3]['options']     = '4|1';
$modversion['blocks'][3]['edit_func']   = 'b_chess_players_edit';
$modversion['blocks'][3]['template']    = 'chess_block_players.html';

// Search
$modversion['hasSearch'] = 0;

// Smarty
$modversion['use_smarty'] = 1;

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'chess_notify_item_info';

$modversion['notification']['category'][1]['name']           = 'game';
$modversion['notification']['category'][1]['title']          = _MI_CHESS_NCAT_GAME;
$modversion['notification']['category'][1]['description']    = _MI_CHESS_NCAT_GAME_DES;
$modversion['notification']['category'][1]['subscribe_from'] = 'game.php';
$modversion['notification']['category'][1]['item_name']      = 'game_id';
$modversion['notification']['category'][1]['allow_bookmark'] = 1;

$modversion['notification']['category'][2]['name']           = 'global';
$modversion['notification']['category'][2]['title']          = _MI_CHESS_NCAT_GLOBAL;
$modversion['notification']['category'][2]['description']    = _MI_CHESS_NCAT_GLOBAL_DES;
$modversion['notification']['category'][2]['subscribe_from'] = array('index.php', 'game.php');

$modversion['notification']['event'][1]['name']          = 'notify_game_move';
$modversion['notification']['event'][1]['category']      = 'game';
$modversion['notification']['event'][1]['title']         = _MI_CHESS_NEVT_MOVE;
$modversion['notification']['event'][1]['caption']       = _MI_CHESS_NEVT_MOVE_CAP;
$modversion['notification']['event'][1]['description']   = _MI_CHESS_NEVT_MOVE_DES;
$modversion['notification']['event'][1]['mail_template'] = 'notify_game_move';
$modversion['notification']['event'][1]['mail_subject']  = _MI_CHESS_NEVT_MOVE_SUB;

$modversion['notification']['event'][2]['name']          = 'notify_challenge_user';
$modversion['notification']['event'][2]['category']      = 'global';
$modversion['notification']['event'][2]['title']         = _MI_CHESS_NEVT_CHAL_USER;
$modversion['notification']['event'][2]['caption']       = _MI_CHESS_NEVT_CHAL_USER_CAP;
$modversion['notification']['event'][2]['description']   = _MI_CHESS_NEVT_CHAL_USER_DES;
$modversion['notification']['event'][2]['mail_template'] = 'notify_challenge_user';
$modversion['notification']['event'][2]['mail_subject']  = _MI_CHESS_NEVT_CHAL_USER_SUB;

$modversion['notification']['event'][3]['name']          = 'notify_challenge_open';
$modversion['notification']['event'][3]['category']      = 'global';
$modversion['notification']['event'][3]['title']         = _MI_CHESS_NEVT_CHAL_OPEN;
$modversion['notification']['event'][3]['caption']       = _MI_CHESS_NEVT_CHAL_OPEN_CAP;
$modversion['notification']['event'][3]['description']   = _MI_CHESS_NEVT_CHAL_OPEN_DES;
$modversion['notification']['event'][3]['mail_template'] = 'notify_challenge_open';
$modversion['notification']['event'][3]['mail_subject']  = _MI_CHESS_NEVT_CHAL_OPEN_SUB;

$modversion['notification']['event'][4]['name']          = 'notify_accept_challenge';
$modversion['notification']['event'][4]['category']      = 'global';
$modversion['notification']['event'][4]['title']         = _MI_CHESS_NEVT_ACPT_CHAL;
$modversion['notification']['event'][4]['caption']       = _MI_CHESS_NEVT_ACPT_CHAL_CAP;
$modversion['notification']['event'][4]['description']   = _MI_CHESS_NEVT_ACPT_CHAL_DES;
$modversion['notification']['event'][4]['mail_template'] = 'notify_accept_challenge';
$modversion['notification']['event'][4]['mail_subject']  = _MI_CHESS_NEVT_ACPT_CHAL_SUB;

$modversion['notification']['event'][5]['name']          = 'notify_request_arbitration';
$modversion['notification']['event'][5]['category']      = 'global';
$modversion['notification']['event'][5]['title']         = _MI_CHESS_NEVT_RQST_ARBT;
$modversion['notification']['event'][5]['caption']       = _MI_CHESS_NEVT_RQST_ARBT_CAP;
$modversion['notification']['event'][5]['description']   = _MI_CHESS_NEVT_RQST_ARBT_DES;
$modversion['notification']['event'][5]['mail_template'] = 'notify_request_arbitration';
$modversion['notification']['event'][5]['mail_subject']  = _MI_CHESS_NEVT_RQST_ARBT_SUB;
$modversion['notification']['event'][5]['admin_only']    = 1;

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'game_id';
$modversion['comments']['pageName'] = 'game.php';

?>