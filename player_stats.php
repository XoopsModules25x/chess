<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
// ------------------------------------------------------------------------- //
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
 * Display an individual chess player's stats.
 *
 * @package chess
 * @subpackage player_stats
 */

/**#@+
 */
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/constants.inc.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/functions.inc.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/ratings.inc.php';

$GLOBALS['xoopsOption']['template_main'] = 'chess_player_stats.tpl';
$xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0; // disable caching
require_once XOOPS_ROOT_PATH . '/header.php';

// user input
$player_uid = (int)(isset($_POST['player_uid']) ? $_POST['player_uid'] : @$_GET['player_uid']);
$player_uname = trim(@$_POST['player_uname']); // unsanitized
$cstart = (int)@$_GET['cstart']; // for page nav: offset of first row of results (challenges) to display (default to 0)
$gstart = (int)@$_GET['gstart']; // for page nav: offset of first row of results (games) to display (default to 0)
$show_option = (int)(isset($_POST['show_option']) ? $_POST['show_option'] : @$_GET['show_option']);

#var_dump($_REQUEST);#*#DEBUG#

// If player username provided, map it to a user ID, overriding any provided value of player user ID.
if (!empty($player_uname)) {
    $player_uid = chess_uname_to_uid($player_uname);

// Otherwise, if player user ID provided, map it to a username.
} elseif (0 != $player_uid) {
    $memberHandler = xoops_getHandler('member');

    $player_user = $memberHandler->getUser($player_uid);

    $player_uname = is_object($player_user) ? $player_user->getVar('uname') : '';
}

// Check that both user ID and username are now defined.
if (0 == $player_uid || empty($player_uname)) {
    redirect_header(XOOPS_URL . '/modules/chess/index.php', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_PLAYER_NOT_FOUND);
}

// Display stats
chess_player_stats($player_uid, $player_uname, $show_option, $cstart, $gstart);

require_once XOOPS_ROOT_PATH . '/footer.php';
/**#@-*/

/**
 * Display stats for player.
 *
 * @param int    $player_uid    Player's user ID
 * @param string $player_uname  Player's username
 * @param int    $show_option   _CHESS_SHOW_ALL_GAMES, _CHESS_SHOW_EXCEPT_SELFPLAY or _CHESS_SHOW_RATED_ONLY
 * @param int    $cstart        Starting offset for challenges page navigator
 * @param int    $gstart        Starting offset for games page navigator
 */
function chess_player_stats($player_uid, $player_uname, $show_option = _CHESS_SHOW_EXCEPT_SELFPLAY, $cstart = 0, $gstart = 0)
{
    global $xoopsDB, $xoopsTpl;

    $rating_system = chess_moduleConfig('rating_system');

    $num_provisional_games = chess_ratings_num_provisional_games();

    // set show_option to default if appropriate

    if (!$show_option || ('none' == $rating_system && _CHESS_SHOW_RATED_ONLY == $show_option)) {
        $show_option = _CHESS_SHOW_EXCEPT_SELFPLAY;
    }

    // get maximum number of items to display on a page, and constrain it to a reasonable value

    $max_items_to_display = chess_moduleConfig('max_items');

    $max_items_to_display = min(max($max_items_to_display, 1), 1000);

    $challenges_table = $xoopsDB->prefix('chess_challenges');

    $games_table = $xoopsDB->prefix('chess_games');

    $ratings_table = $xoopsDB->prefix('chess_ratings');

    $player = [];

    $player['uid'] = $player_uid;

    $player['uname'] = $player_uname;

    // ---------------------------------------------

    // form for selecting player and display-options

    // ---------------------------------------------

    // security token not needed for this form

    $form = new XoopsThemeForm(_MD_CHESS_SELECT_PLAYER, 'form1', 'player_stats.php');

    $form->addElement(new XoopsFormText('', 'player_uname', 25, 50, $player_uname));

    $form->addElement(new XoopsFormButton('', 'submit_select_player', _MD_CHESS_SUBMIT_BUTTON, 'submit'));

    $menu_show_option = new XoopsFormSelect('', 'show_option', $show_option, 1, false);

    $menu_show_option->addOption(_CHESS_SHOW_ALL_GAMES, _MD_CHESS_SHOW_ALL_GAMES);

    $menu_show_option->addOption(_CHESS_SHOW_EXCEPT_SELFPLAY, _MD_CHESS_SHOW_EXCEPT_SELFPLAY); // default

    if ('none' != $rating_system) {
        $menu_show_option->addOption(_CHESS_SHOW_RATED_ONLY, _MD_CHESS_SHOW_RATED_ONLY);
    }

    $form->addElement($menu_show_option);

    $form->assign($xoopsTpl);

    // user IDs that will require mapping to usernames

    $userids = [];

    // --------------

    // player's games

    // --------------

    // Two queries are performed, one without a limit clause to count the total number of rows for the page navigator,

    // and one with a limit clause to get the data for display on the current page.

    // SQL_CALC_FOUND_ROWS and FOUND_ROWS(), available in MySQL 4.0.0, provide a more efficient way of doing this.

    $where = "'$player_uid' IN (white_uid, black_uid)";

    if (_CHESS_SHOW_EXCEPT_SELFPLAY == $show_option) {
        $where .= ' AND white_uid != black_uid';
    } elseif (_CHESS_SHOW_RATED_ONLY == $show_option) {
        $where .= ' AND is_rated = "1" AND white_uid != black_uid';
    }

    $result = $xoopsDB->query("SELECT COUNT(*) FROM $games_table WHERE $where");

    [$num_items] = $xoopsDB->fetchRow($result);

    $xoopsDB->freeRecordSet($result);

    $result = $xoopsDB->query("
		SELECT   game_id, fen_active_color, white_uid, black_uid, pgn_result, is_rated,
			UNIX_TIMESTAMP(GREATEST(create_date,start_date,last_date)) AS last_activity
		FROM      $games_table
		WHERE     $where
		ORDER BY  last_activity DESC
		LIMIT     $gstart, $max_items_to_display
	");

    $games = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $games[] = [
            'game_id' => $row['game_id'],
            'white_uid' => $row['white_uid'],
            'black_uid' => $row['black_uid'],
            'fen_active_color' => $row['fen_active_color'],
            'pgn_result' => $row['pgn_result'],
            'last_activity' => $row['last_activity'],
            'is_rated' => $row['is_rated'],
        ];

        // save user IDs that will require mapping to usernames

        if ($row['white_uid']) {
            $userids[$row['white_uid']] = 1;
        }

        if ($row['black_uid']) {
            $userids[$row['black_uid']] = 1;
        }
    }

    $xoopsDB->freeRecordSet($result);

    $show_option_urlparam = "&amp;show_option=$show_option";

    $games_pagenav = new XoopsPageNav($num_items, $max_items_to_display, $gstart, 'gstart', "player_uid=$player_uid$show_option_urlparam");

    // -------------------

    // player's challenges

    // -------------------

    // Two queries are performed, one without a limit clause to count the total number of rows for the page navigator,

    // and one with a limit clause to get the data for display on the current page.

    // SQL_CALC_FOUND_ROWS and FOUND_ROWS(), available in MySQL 4.0.0, provide a more efficient way of doing this.

    $where = "'$player_uid' IN (player1_uid, player2_uid)";

    if (_CHESS_SHOW_RATED_ONLY == $show_option) {
        $where .= ' AND is_rated = "1"';
    }

    $result = $xoopsDB->query("SELECT COUNT(*) FROM $challenges_table WHERE $where");

    [$num_items] = $xoopsDB->fetchRow($result);

    $xoopsDB->freeRecordSet($result);

    $result = $xoopsDB->query("
		SELECT   challenge_id, game_type, color_option, player1_uid, player2_uid, UNIX_TIMESTAMP(create_date) AS create_date, is_rated
		FROM     $challenges_table
		WHERE    $where
		ORDER BY create_date DESC
		LIMIT    $cstart, $max_items_to_display
	");

    $challenges = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $challenges[] = [
            'challenge_id' => $row['challenge_id'],
            'game_type' => $row['game_type'],
            'color_option' => $row['color_option'],
            'player1_uid' => $row['player1_uid'],
            'player2_uid' => $row['player2_uid'],
            'create_date' => $row['create_date'],
            'is_rated' => $row['is_rated'],
        ];

        // save user IDs that will require mapping to usernames

        if ($row['player1_uid']) {
            $userids[$row['player1_uid']] = 1;
        }

        if ($row['player2_uid']) {
            $userids[$row['player2_uid']] = 1;
        }
    }

    $xoopsDB->freeRecordSet($result);

    $show_option_urlparam = "&amp;show_option=$show_option";

    $challenges_pagenav = new XoopsPageNav($num_items, $max_items_to_display, $cstart, 'cstart', "player_uid=$player_uid$show_option_urlparam");

    // ---------

    // usernames

    // ---------

    // get mapping of user IDs to usernames

    $memberHandler = xoops_getHandler('member');

    $criteria = new Criteria('uid', '(' . implode(',', array_keys($userids)) . ')', 'IN');

    $usernames = $memberHandler->getUserList($criteria);

    // add usernames to $games

    foreach ($games as $k => $game) {
        $games[$k]['white_uname'] = $usernames[$game['white_uid']] ?? '?';

        $games[$k]['black_uname'] = $usernames[$game['black_uid']] ?? '?';
    }

    // add usernames to $challenges

    foreach ($challenges as $k => $challenge) {
        $challenges[$k]['player1_uname'] = $usernames[$challenge['player1_uid']] ?? '?';

        $challenges[$k]['player2_uname'] = $usernames[$challenge['player2_uid']] ?? '?';
    }

    // ---------------------------------------------------

    // player's rating info (if rating feature is enabled)

    // ---------------------------------------------------

    if ('none' != $rating_system) {
        $result = $xoopsDB->query("
			SELECT   player_uid, rating, games_won, games_lost, games_drawn, (games_won+games_lost+games_drawn) AS games_played
			FROM     $ratings_table
			ORDER BY rating DESC, player_uid ASC
		");

        $ranking = 0;

        while (false !== ($row = $xoopsDB->fetchArray($result))) {
            if ($row['games_played'] >= $num_provisional_games) {
                ++$ranking;
            }

            if ($row['player_uid'] == $player_uid) {
                break;
            }
        }

        $xoopsDB->freeRecordSet($result);

        if ($row['player_uid'] == $player_uid) {
            $player['ranking'] = $ranking;

            $player['rating'] = $row['rating'];

            $player['games_won'] = $row['games_won'];

            $player['games_lost'] = $row['games_lost'];

            $player['games_drawn'] = $row['games_drawn'];

            $player['games_played'] = $row['games_played'];
        }
    }

    // Template variables

    $player['games'] = $games;

    $player['challenges'] = $challenges;

    $xoopsTpl->assign('chess_player', $player);

    $xoopsTpl->assign('chess_rating_system', chess_moduleConfig('rating_system'));

    $xoopsTpl->assign('chess_provisional_games', $num_provisional_games);

    $xoopsTpl->assign('chess_show_option_urlparam', $show_option_urlparam);

    $xoopsTpl->assign('chess_games_pagenav', $games_pagenav->renderNav());

    $xoopsTpl->assign('chess_challenges_pagenav', $challenges_pagenav->renderNav());
}
