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

require_once 'admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

xoops_cp_header();

switch (@$_GET['op']) {
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

// ------------------------
function chess_admin_menu()
{
	global $xoopsModule;

echo '
	<h4> ' . _AM_CHESS_CONF . " </h4>
	<table width='100%' border='0' cellspacing='1' class='outer'>
	<tr>
		<td><a href='" . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/admin/index.php?op=suspended_games'>" . _AM_CHESS_SUSPENDED_GAMES . '</a>
		<td>' . _AM_CHESS_SUSPENDED_GAMES_DES . "</td>
	</tr>
	<tr>
		<td><a href='" . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/admin/index.php?op=active_games'>" . _AM_CHESS_ACTIVE_GAMES . '</a>
		<td>' . _AM_CHESS_ACTIVE_GAMES_DES . "</td>
	</tr>
	<tr>
		<td><a href='" . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/admin/index.php?op=challenges'>" . _AM_CHESS_CHALLENGES . '</a>
		<td>' . _AM_CHESS_CHALLENGES_DES . "</td>
	</tr>
	<tr>
		<td><a href='" . XOOPS_URL . '/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid') . "'>" . _AM_CHESS_PREFS . '</a>
		<td>' . _AM_CHESS_PREFS_DESC . '</td>
	</tr>
	</table>
';
}

// -----------------------------------
function chess_admin_suspended_games()
{
	global $xoopsDB, $xoopsModule;

	$member_handler = xoops_getHandler('member');

	$games_table = $xoopsDB->prefix('chess_games');

	$result = $xoopsDB->query(trim("
		SELECT   game_id, white_uid, black_uid, UNIX_TIMESTAMP(start_date) AS start_date, suspended
		FROM     $games_table
		WHERE    suspended != ''
		ORDER BY suspended
	"));

	if ($xoopsDB->getRowsNum($result) > 0) {

		echo '<h3>' ._AM_CHESS_SUSPENDED_GAMES. "</h3>\n";

	 	while ($row = $xoopsDB->fetchArray($result)) {

			$user_white     = $member_handler->getUser($row['white_uid']);
			$username_white =  is_object($user_white) ? $user_white->getVar('uname') : '(open)';

			$user_black     = $member_handler->getUser($row['black_uid']);
			$username_black =  is_object($user_black) ? $user_black->getVar('uname') : '(open)';

			$date = $row['start_date'] ? date('Y.m.d', $row['start_date']) : 'not yet started';

			$title_text = "Game #{$row['game_id']}&nbsp;&nbsp;&nbsp;$username_white vs. $username_black&nbsp;&nbsp;&nbsp;($date)";
			$form = new XoopsThemeForm($title_text, "game_{$row['game_id']}", XOOPS_URL. '/modules/' .$xoopsModule->getVar('dirname'). "/game.php?game_id={$row['game_id']}");

			[$date, $suspender_uid, $type, $explain] = explode('|', $row['suspended']);

			$suspender_user     = $member_handler->getUser($suspender_uid);
			$suspender_username =  is_object($suspender_user) ? $suspender_user->getVar('uname') : _AM_UNKNOWN_USER;

			$form->addElement(new XoopsFormLabel(_AM_CHESS_WHEN_SUSPENDED    . ':', formatTimestamp(strtotime($date))));
			$form->addElement(new XoopsFormLabel(_AM_CHESS_SUSPENDED_BY      . ':', $suspender_username));
			$form->addElement(new XoopsFormLabel(_AM_CHESS_SUSPENSION_TYPE   . ':', $type));
			$form->addElement(new XoopsFormLabel(_AM_CHESS_SUSPENSION_REASON . ':', $explain));

			$form->addElement(new XoopsFormButton('', 'submit', _AM_CHESS_ARBITRATE_SUBMIT, 'submit'));

			$form->addElement(new XoopsFormHidden('show_arbiter_ctrl', 1));

			$form->display();
		}

	} else {

		echo '<h3>' ._AM_CHESS_NO_SUSPENDED_GAMES. "</h3>\n";
	}

	$xoopsDB->freeRecordSet($result);
}

// --------------------------------
function chess_admin_active_games()
{
	global $xoopsDB, $xoopsModule;

	$member_handler = xoops_getHandler('member');

	$games_table = $xoopsDB->prefix('chess_games');

	$result = $xoopsDB->query(trim("
		SELECT   game_id, white_uid, black_uid, UNIX_TIMESTAMP(start_date) AS start_date
		FROM     $games_table
		WHERE    pgn_result = '*' and suspended = ''
		ORDER BY last_date DESC, start_date DESC, create_date DESC
	"));

	if ($xoopsDB->getRowsNum($result) > 0) {

		echo '<h3>' ._AM_CHESS_ACTIVE_GAMES. "</h3>\n";

	 	while ($row = $xoopsDB->fetchArray($result)) {

			$user_white     = $member_handler->getUser($row['white_uid']);
			$username_white =  is_object($user_white) ? $user_white->getVar('uname') : '(open)';

			$user_black     = $member_handler->getUser($row['black_uid']);
			$username_black =  is_object($user_black) ? $user_black->getVar('uname') : '(open)';

			$date = $row['start_date'] ? date('Y.m.d', $row['start_date']) : 'not yet started';

			$title_text = "Game #{$row['game_id']}&nbsp;&nbsp;&nbsp;$username_white vs. $username_black&nbsp;&nbsp;&nbsp;($date)";
			$form = new XoopsThemeForm($title_text, "game_{$row['game_id']}", XOOPS_URL. '/modules/' .$xoopsModule->getVar('dirname'). "/game.php?game_id={$row['game_id']}");

			$form->addElement(new XoopsFormButton('', 'submit', _AM_CHESS_ARBITRATE_SUBMIT, 'submit'));

			$form->addElement(new XoopsFormHidden('show_arbiter_ctrl', 1));

			$form->display();
		}

	} else {

		echo '<h3>' ._AM_CHESS_NO_ACTIVE_GAMES. "</h3>\n";
	}

	$xoopsDB->freeRecordSet($result);
}

// --------------------------------
function chess_admin_challenges()
{
	global $xoopsDB, $xoopsModule;

	$member_handler = xoops_getHandler('member');

	echo '<h3>' ._AM_CHESS_CHALLENGES. "</h3>\n";

	$challenges_table = $xoopsDB->prefix('chess_challenges');

	$result = $xoopsDB->query(trim("
		SELECT challenge_id, game_type, color_option, player1_uid, player2_uid, UNIX_TIMESTAMP(create_date) AS create_date
		FROM $challenges_table
		ORDER BY create_date DESC
	"));

	if ($xoopsDB->getRowsNum($result) > 0) {

	 	while ($row = $xoopsDB->fetchArray($result)) {

			$user_player1     = $member_handler->getUser($row['player1_uid']);
			$username_player1 =  is_object($user_player1) ? $user_player1->getVar('uname') : '?';

			$user_player2     = $member_handler->getUser($row['player2_uid']);
			$username_player2 =  is_object($user_player2) ? $user_player2->getVar('uname') : '(open)';

			$date = date('Y.m.d', $row['create_date']);

			$title_text = "Challenge #{$row['challenge_id']}&nbsp;&nbsp;&nbsp;$username_player1 challenged: $username_player2&nbsp;&nbsp;&nbsp;(created $date)";
			$form = new XoopsThemeForm($title_text, "challenge_{$row['challenge_id']}", XOOPS_URL. '/modules/' .$xoopsModule->getVar('dirname'). "/create.php?challenge_id={$row['challenge_id']}");

			$form->addElement(new XoopsFormButton('', 'submit', _AM_CHESS_ARBITRATE_SUBMIT, 'submit'));

			$form->addElement(new XoopsFormHidden('show_arbiter_ctrl', 1));

			$form->display();
		}

	} else {

		echo '<h3>' ._AM_CHESS_NO_CHALLENGES. "</h3>\n";
	}

	$xoopsDB->freeRecordSet($result);
}

?>
