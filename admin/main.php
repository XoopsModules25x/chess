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
 * Admin page
 *
 * @package chess
 * @subpackage admin
 */

/**#@+
 */
require_once 'admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/functions.inc.php';

// user input
$op    = chess_sanitize(@$_GET['op']);
$start = intval(@$_GET['start']); // offset of first row of table to display (default to 0)

// get maximum number of items to display on a page, and constrain it to a reasonable value
$max_items_to_display = chess_moduleConfig('max_items');
$max_items_to_display = min(max($max_items_to_display, 1), 1000);

xoops_cp_header();

switch ($op) {
    case 'suspended_games':
        chess_admin_suspended_games();
        break;
    case 'active_games':
        chess_admin_active_games();
        break;
    case 'challenges':
        chess_admin_challenges();
        break;
    default:
        chess_admin_menu();
        break;
}

xoops_cp_footer();
/**#@-*/

/**
 * Admin menu
 */
function chess_admin_menu()
{
    global $xoopsModule;

    echo "
	<h4> "._AM_CHESS_CONF." </h4>
	<table width='100%' border='0' cellspacing='1' class='outer'>
	<tr>
		<td><a href='" .XOOPS_URL. "/modules/" .$xoopsModule->getVar('dirname'). "/admin/index.php?op=suspended_games'>" ._AM_CHESS_SUSPENDED_GAMES. "</a>
		<td>" ._AM_CHESS_SUSPENDED_GAMES_DES. "</td>
	</tr>
	<tr>
		<td><a href='" .XOOPS_URL. "/modules/" .$xoopsModule->getVar('dirname'). "/admin/index.php?op=active_games'>" ._AM_CHESS_ACTIVE_GAMES. "</a>
		<td>" ._AM_CHESS_ACTIVE_GAMES_DES. "</td>
	</tr>
	<tr>
		<td><a href='" .XOOPS_URL. "/modules/" .$xoopsModule->getVar('dirname'). "/admin/index.php?op=challenges'>" ._AM_CHESS_CHALLENGES. "</a>
		<td>" ._AM_CHESS_CHALLENGES_DES. "</td>
	</tr>
	<tr>
		<td><a href='" .XOOPS_URL. "/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" .$xoopsModule->getVar('mid'). "'>" ._AM_CHESS_PREFS. "</a>
		<td>" ._AM_CHESS_PREFS_DESC. "</td>
	</tr>
	</table>
";
}

/**
 * Display suspended games
 */
function chess_admin_suspended_games()
{
    global $start, $max_items_to_display, $op, $xoopsDB, $xoopsModule;

    $member_handler =& xoops_gethandler('member');

    // Two queries are performed, one without a limit clause to count the total number of rows for the page navigator,
    // and one with a limit clause to get the data for display on the current page.
    // SQL_CALC_FOUND_ROWS and FOUND_ROWS(), available in MySQL 4.0.0, provide a more efficient way of doing this.

    $games_table = $xoopsDB->prefix('chess_games');

    $result = $xoopsDB->query("SELECT COUNT(*) FROM $games_table WHERE suspended != ''");
    list($num_rows) = $xoopsDB->fetchRow($result);
    $xoopsDB->freeRecordSet($result);

    // Sort by date-suspended in ascending order, so that games that were suspended the earliest will be displayed
    // at the top, and can more easily be arbitrated on a first-come first-serve basis.
    // Note that the suspended column begins with the date-suspended in the format 'YYYY-MM-DD HH:MM:SS', so the sorting
    // will work as desired.
    $result = $xoopsDB->query(trim("
		SELECT   game_id, white_uid, black_uid, UNIX_TIMESTAMP(start_date) AS start_date, suspended
		FROM     $games_table
		WHERE    suspended != ''
		ORDER BY suspended
		LIMIT    $start, $max_items_to_display
	"));

    if ($xoopsDB->getRowsNum($result) > 0) {
        echo '<h3>' ._AM_CHESS_SUSPENDED_GAMES. "</h3>\n";

        while ($row = $xoopsDB->fetchArray($result)) {
            $user_white     =& $member_handler->getUser($row['white_uid']);
            $username_white =  is_object($user_white) ? $user_white->getVar('uname') : '(open)';

            $user_black     =& $member_handler->getUser($row['black_uid']);
            $username_black =  is_object($user_black) ? $user_black->getVar('uname') : '(open)';

            $date = $row['start_date'] ? date('Y.m.d', $row['start_date']) : 'not yet started';

            $title_text = _AM_CHESS_GAME. " #{$row['game_id']}&nbsp;&nbsp;&nbsp;$username_white " ._AM_CHESS_VS. " $username_black&nbsp;&nbsp;&nbsp;($date)";
            $form = new XoopsThemeForm($title_text, "game_{$row['game_id']}", XOOPS_URL. '/modules/' .$xoopsModule->getVar('dirname'). "/game.php?game_id={$row['game_id']}", 'post', true);

            list($date, $suspender_uid, $type, $explain) = explode('|', $row['suspended']);

            switch ($type) {
                case 'arbiter_suspend':
                    $type_display = _AM_CHESS_SUSP_TYPE_ARBITER;
                    break;
                case 'want_arbitration':
                    $type_display = _AM_CHESS_SUSP_TYPE_PLAYER;
                    break;
                default:
                    $type_display = _AM_CHESS_ERROR;
                    break;
            }

            $suspender_user     =& $member_handler->getUser($suspender_uid);
            $suspender_username =  is_object($suspender_user) ? $suspender_user->getVar('uname') : _AM_CHESS_UNKNOWN_USER;

            $form->addElement(new XoopsFormLabel(_AM_CHESS_WHEN_SUSPENDED    . ':', formatTimestamp(strtotime($date))));
            $form->addElement(new XoopsFormLabel(_AM_CHESS_SUSPENDED_BY      . ':', $suspender_username));
            $form->addElement(new XoopsFormLabel(_AM_CHESS_SUSPENSION_TYPE   . ':', $type_display));
            $form->addElement(new XoopsFormLabel(_AM_CHESS_SUSPENSION_REASON . ':', $explain));

            $form->addElement(new XoopsFormButton('', 'submit', _AM_CHESS_ARBITRATE_SUBMIT, 'submit'));

            $form->addElement(new XoopsFormHidden('show_arbiter_ctrl', 1));

            $form->display();
        }

        $pagenav = new XoopsPageNav($num_rows, $max_items_to_display, $start, 'start', "op=$op");
        echo '<div align="center">' . $pagenav->renderNav() . "&nbsp;</div>\n";
    } else {
        echo '<h3>' ._AM_CHESS_NO_SUSPENDED_GAMES. "</h3>\n";
    }

    $xoopsDB->freeRecordSet($result);
}

/**
 * Display active games
 */
function chess_admin_active_games()
{
    global $start, $max_items_to_display, $op, $xoopsDB, $xoopsModule;

    $member_handler =& xoops_gethandler('member');

    // Two queries are performed, one without a limit clause to count the total number of rows for the page navigator,
    // and one with a limit clause to get the data for display on the current page.
    // SQL_CALC_FOUND_ROWS and FOUND_ROWS(), available in MySQL 4.0.0, provide a more efficient way of doing this.

    $games_table = $xoopsDB->prefix('chess_games');

    $result = $xoopsDB->query("SELECT COUNT(*) FROM $games_table WHERE pgn_result = '*' and suspended = ''");
    list($num_rows) = $xoopsDB->fetchRow($result);
    $xoopsDB->freeRecordSet($result);

    $result = $xoopsDB->query(trim("
		SELECT   game_id, white_uid, black_uid, UNIX_TIMESTAMP(start_date) AS start_date, GREATEST(create_date,start_date,last_date) AS most_recent_date
		FROM     $games_table
		WHERE    pgn_result = '*' and suspended = ''
		ORDER BY most_recent_date DESC
		LIMIT    $start, $max_items_to_display
	"));

    if ($xoopsDB->getRowsNum($result) > 0) {
        echo '<h3>' ._AM_CHESS_ACTIVE_GAMES. "</h3>\n";

        while ($row = $xoopsDB->fetchArray($result)) {
            $user_white     =& $member_handler->getUser($row['white_uid']);
            $username_white =  is_object($user_white) ? $user_white->getVar('uname') : '(open)';

            $user_black     =& $member_handler->getUser($row['black_uid']);
            $username_black =  is_object($user_black) ? $user_black->getVar('uname') : '(open)';

            $date = $row['start_date'] ? date('Y.m.d', $row['start_date']) : 'not yet started';

            $title_text = _AM_CHESS_GAME. " #{$row['game_id']}&nbsp;&nbsp;&nbsp;$username_white " ._AM_CHESS_VS. " $username_black&nbsp;&nbsp;&nbsp;($date)";
            $form = new XoopsThemeForm($title_text, "game_{$row['game_id']}", XOOPS_URL. '/modules/' .$xoopsModule->getVar('dirname'). "/game.php?game_id={$row['game_id']}", 'post', true);

            $form->addElement(new XoopsFormButton('', 'submit', _AM_CHESS_ARBITRATE_SUBMIT, 'submit'));

            $form->addElement(new XoopsFormHidden('show_arbiter_ctrl', 1));

            $form->display();
        }

        $pagenav = new XoopsPageNav($num_rows, $max_items_to_display, $start, 'start', "op=$op");
        echo '<div align="center">' . $pagenav->renderNav() . "&nbsp;</div>\n";
    } else {
        echo '<h3>' ._AM_CHESS_NO_ACTIVE_GAMES. "</h3>\n";
    }

    $xoopsDB->freeRecordSet($result);
}

/**
 * Display challenges
 */
function chess_admin_challenges()
{
    global $start, $max_items_to_display, $op, $xoopsDB, $xoopsModule;

    $member_handler =& xoops_gethandler('member');

    // Two queries are performed, one without a limit clause to count the total number of rows for the page navigator,
    // and one with a limit clause to get the data for display on the current page.
    // SQL_CALC_FOUND_ROWS and FOUND_ROWS(), available in MySQL 4.0.0, provide a more efficient way of doing this.

    $challenges_table = $xoopsDB->prefix('chess_challenges');

    $result = $xoopsDB->query("SELECT COUNT(*) FROM $challenges_table");
    list($num_rows) = $xoopsDB->fetchRow($result);
    $xoopsDB->freeRecordSet($result);

    $result = $xoopsDB->query(trim("
		SELECT   challenge_id, game_type, color_option, player1_uid, player2_uid, UNIX_TIMESTAMP(create_date) AS create_date
		FROM     $challenges_table
		ORDER BY create_date DESC
		LIMIT    $start, $max_items_to_display
	"));

    if ($xoopsDB->getRowsNum($result) > 0) {
        echo '<h3>' ._AM_CHESS_CHALLENGES. "</h3>\n";

        while ($row = $xoopsDB->fetchArray($result)) {
            $user_player1     =& $member_handler->getUser($row['player1_uid']);
            $username_player1 =  is_object($user_player1) ? $user_player1->getVar('uname') : '?';

            $user_player2     =& $member_handler->getUser($row['player2_uid']);
            $username_player2 =  is_object($user_player2) ? $user_player2->getVar('uname') : '(open)';

            $date = date('Y.m.d', $row['create_date']);

            $title_text = _AM_CHESS_CHALLENGE. " #{$row['challenge_id']}&nbsp;&nbsp;&nbsp;$username_player1 " ._AM_CHESS_CHALLENGED. ": $username_player2&nbsp;&nbsp;&nbsp;(" ._AM_CHESS_CREATED. " $date)";
            $form = new XoopsThemeForm($title_text, "challenge_{$row['challenge_id']}", XOOPS_URL. '/modules/' .$xoopsModule->getVar('dirname'). "/create.php?challenge_id={$row['challenge_id']}", 'post', true);

            $form->addElement(new XoopsFormButton('', 'submit', _AM_CHESS_ARBITRATE_SUBMIT, 'submit'));

            $form->addElement(new XoopsFormHidden('show_arbiter_ctrl', 1));

            $form->display();
        }

        $pagenav = new XoopsPageNav($num_rows, $max_items_to_display, $start, 'start', "op=$op");
        echo '<div align="center">' . $pagenav->renderNav() . "&nbsp;</div>\n";
    } else {
        echo '<h3>' ._AM_CHESS_NO_CHALLENGES. "</h3>\n";
    }

    $xoopsDB->freeRecordSet($result);
}
