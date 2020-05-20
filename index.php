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
 * Generates main chess page, which displays lists of games and challenges.
 *
 * @package chess
 * @subpackage index
 */

/**#@+
 */
require dirname(dirname(__DIR__)) . '/mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'chess_games.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/constants.inc.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/functions.inc.php';

#var_dump($_REQUEST);#*#DEBUG#

chess_get_games();

require_once XOOPS_ROOT_PATH . '/footer.php';
/**#@-*/

/**
 * Generate lists of games and challenges.
 */
function chess_get_games()
{
    global $xoopsDB, $xoopsTpl;

    // ----------

    // user input

    // ----------

    // offset of first row of challenges table to display (default to 0)

    $cstart = (int)(isset($_POST['cstart']) ? $_POST['cstart'] : @$_GET['cstart']);

    // offset of first row of games table to display (default to 0)

    $gstart = (int)(isset($_POST['gstart']) ? $_POST['gstart'] : @$_GET['gstart']);

    // challenges display option

    $cshow = (int)(isset($_POST['cshow']) ? $_POST['cshow'] : @$_GET['cshow']);

    // games display option 1

    $gshow1 = (int)(isset($_POST['gshow1']) ? $_POST['gshow1'] : @$_GET['gshow1']);

    // games display option 2

    $gshow2 = (int)(isset($_POST['gshow2']) ? $_POST['gshow2'] : @$_GET['gshow2']);

    // set show-options to default if undefined

    if (!$cshow) {
        $cshow = _CHESS_SHOW_CHALLENGES_BOTH;
    }

    if (!$gshow1) {
        $gshow1 = _CHESS_SHOW_GAMES_BOTH;
    }

    if (!$gshow2) {
        $gshow2 = _CHESS_SHOW_GAMES_UNRATED;
    }

    // get maximum number of items to display on a page, and constrain it to a reasonable value

    $max_items_to_display = chess_moduleConfig('max_items');

    $max_items_to_display = min(max($max_items_to_display, 1), 1000);

    $xoopsTpl->assign('chess_date_format', _MEDIUMDATESTRING);

    // user IDs that will require mapping to usernames

    $userids = [];

    // -----

    // games

    // -----

    // Two queries are performed, one without a limit clause to count the total number of rows for the page navigator,

    // and one with a limit clause to get the data for display on the current page.

    // SQL_CALC_FOUND_ROWS and FOUND_ROWS(), available in MySQL 4.0.0, provide a more efficient way of doing this.

    $games_table = $xoopsDB->prefix('chess_games');

    $where = 'white_uid != black_uid';

    switch ($gshow1) {
        case 1:
            $where .= " AND pgn_result = '*'";
            break;
        case 2:
            $where .= " AND pgn_result != '*'";
            break;
    }

    if (1 == $gshow2) {
        $where .= " AND is_rated = '1'";
    }

    $result = $xoopsDB->query("SELECT COUNT(*) FROM $games_table WHERE $where");

    [$num_games] = $xoopsDB->fetchRow($result);

    $xoopsDB->freeRecordSet($result);

    $result = $xoopsDB->query(trim("
		SELECT   game_id, fen_active_color, white_uid, black_uid, pgn_result, is_rated,
			UNIX_TIMESTAMP(GREATEST(create_date,start_date,last_date)) AS last_activity
		FROM     $games_table
		WHERE    $where
		ORDER BY last_activity DESC
		LIMIT    $gstart, $max_items_to_display
	"));

    $games = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $games[] = [
            'game_id' => $row['game_id'],
            'white_uid' => $row['white_uid'],
            'black_uid' => $row['black_uid'],
            'last_activity' => $row['last_activity'],
            'fen_active_color' => $row['fen_active_color'],
            'pgn_result' => $row['pgn_result'],
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

    $games_pagenav = new XoopsPageNav($num_games, $max_items_to_display, $gstart, 'gstart', "cstart=$cstart&amp;cshow=$cshow&amp;gshow1=$gshow1&amp;gshow2=$gshow2");

    $xoopsTpl->assign('chess_games_pagenav', $games_pagenav->renderNav());

    // ----------

    // challenges

    // ----------

    // Two queries are performed, one without a limit clause to count the total number of rows for the page navigator,

    // and one with a limit clause to get the data for display on the current page.

    // SQL_CALC_FOUND_ROWS and FOUND_ROWS(), available in MySQL 4.0.0, provide a more efficient way of doing this.

    $challenges_table = $xoopsDB->prefix('chess_challenges');

    switch ($cshow) {
        case _CHESS_SHOW_CHALLENGES_OPEN:
            $where = "game_type = 'open'";
            break;
        case _CHESS_SHOW_CHALLENGES_USER:
            $where = "game_type = 'user'";
            break;
        default:
            $where = 1;
            break;
    }

    $result = $xoopsDB->query("SELECT COUNT(*) FROM $challenges_table WHERE $where");

    [$num_challenges] = $xoopsDB->fetchRow($result);

    $xoopsDB->freeRecordSet($result);

    $result = $xoopsDB->query(trim("
		SELECT   challenge_id, game_type, color_option, player1_uid, player2_uid, UNIX_TIMESTAMP(create_date) AS create_date, is_rated
		FROM     $challenges_table
		WHERE    $where
		ORDER BY create_date DESC
		LIMIT    $cstart, $max_items_to_display
	"));

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

    $challenges_pagenav = new XoopsPageNav($num_challenges, $max_items_to_display, $cstart, 'cstart', "gstart=$gstart&amp;cshow=$cshow&amp;gshow1=$gshow1&amp;gshow2=$gshow2");

    $xoopsTpl->assign('chess_challenges_pagenav', $challenges_pagenav->renderNav());

    // ---------

    // usernames

    // ---------

    // get mapping of user IDs to usernames

    $memberHandler = xoops_getHandler('member');

    $criteria = new Criteria('uid', '(' . implode(',', array_keys($userids)) . ')', 'IN');

    $usernames = $memberHandler->getUserList($criteria);

    // add usernames to $games

    foreach ($games as $k => $game) {
        $games[$k]['username_white'] = $usernames[$game['white_uid']] ?? '?';

        $games[$k]['username_black'] = $usernames[$game['black_uid']] ?? '?';
    }

    // add usernames to $challenges

    foreach ($challenges as $k => $challenge) {
        $challenges[$k]['username_player1'] = $usernames[$challenge['player1_uid']] ?? '?';

        $challenges[$k]['username_player2'] = $usernames[$challenge['player2_uid']] ?? '?';
    }

    $xoopsTpl->assign('chess_games', $games);

    $xoopsTpl->assign('chess_challenges', $challenges);

    $xoopsTpl->assign('chess_rating_system', chess_moduleConfig('rating_system'));

    // -----

    // forms

    // -----

    // security token not needed for this form

    $form1 = new XoopsThemeForm('', 'form1', 'index.php');

    $form1->addElement(new XoopsFormButton('', 'submit', _MD_CHESS_SUBMIT_BUTTON, 'submit'));

    $menu_cshow = new XoopsFormSelect('', 'cshow', $cshow, 1, false);

    $menu_cshow->addOption(_CHESS_SHOW_CHALLENGES_OPEN, _MD_CHESS_SHOW_CHALLENGES_OPEN);

    $menu_cshow->addOption(_CHESS_SHOW_CHALLENGES_USER, _MD_CHESS_SHOW_CHALLENGES_USER);

    $menu_cshow->addOption(_CHESS_SHOW_CHALLENGES_BOTH, _MD_CHESS_SHOW_CHALLENGES_BOTH);

    $form1->addElement($menu_cshow);

    $form1->addElement(new XoopsFormHidden('gstart', $gstart));

    $form1->addElement(new XoopsFormHidden('gshow1', $gshow1));

    $form1->addElement(new XoopsFormHidden('gshow2', $gshow2));

    $form1->assign($xoopsTpl);

    // security token not needed for this form

    $form2 = new XoopsThemeForm('', 'form2', 'index.php');

    $form2->addElement(new XoopsFormButton('', 'submit', _MD_CHESS_SUBMIT_BUTTON, 'submit'));

    $menu_gshow1 = new XoopsFormSelect('', 'gshow1', $gshow1, 1, false);

    $menu_gshow1->addOption(_CHESS_SHOW_GAMES_INPLAY, _MD_CHESS_SHOW_GAMES_INPLAY);

    $menu_gshow1->addOption(_CHESS_SHOW_GAMES_CONCLUDED, _MD_CHESS_SHOW_GAMES_CONCLUDED);

    $menu_gshow1->addOption(_CHESS_SHOW_GAMES_BOTH, _MD_CHESS_SHOW_GAMES_BOTH);

    $form2->addElement($menu_gshow1);

    $menu_gshow2 = new XoopsFormSelect('', 'gshow2', $gshow2, 1, false);

    $menu_gshow2->addOption(_CHESS_SHOW_GAMES_RATED, _MD_CHESS_SHOW_GAMES_RATED);

    $menu_gshow2->addOption(_CHESS_SHOW_GAMES_UNRATED, _MD_CHESS_SHOW_GAMES_UNRATED);

    $form2->addElement($menu_gshow2);

    $form2->addElement(new XoopsFormHidden('cstart', $cstart));

    $form2->addElement(new XoopsFormHidden('cshow', $cshow));

    $form2->assign($xoopsTpl);

    #*#DEBUG# - trying something unrelated to the chess module
/***
    $configHandler = xoops_getHandler('config');
    $clist = $configHandler->getConfigList(18);
    var_dump('clist', $clist);
***/
}
