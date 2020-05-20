<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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
 * This module handles chess game creation.
 *
 * The following forms are generated and processed:
 *
 *  - Create-form 1 - Specify game type (open challenge, individual challenge or self-play).
 *  - Create-form 2 - Specify opponent (for individual challenge), and color and rating options (for open challenge and individual challenge).
 *  - Create-form 3 - Confirm entries from forms 1 and 2.
 *  - Accept-form   - Accept challenge.
 *  - Delete-form   - Delete challenge.
 *
 * @package chess
 * @subpackage challenge
 */

/**#@+
 */
require_once '../../mainfile.php';
$xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0; // disable caching
require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/constants.inc.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/functions.inc.php';

#var_dump($_REQUEST);#*#DEBUG#

if (!chess_can_play()) {
	redirect_header(XOOPS_URL.'/index.php', _CHESS_REDIRECT_DELAY_FAILURE, _NOPERM);
}

// user input
$gametype          = chess_sanitize(@$_POST['gametype']);
$opponent          = chess_sanitize(trim(@$_POST['opponent']), _CHESS_USERNAME_ALLOWED_CHARACTERS);
$opponent_uid      = !empty($opponent) ? chess_opponent_uid($opponent) : 0;
$fen               = chess_moduleConfig('allow_setup') ? chess_sanitize(trim(@$_POST['fen']), 'A-Za-z0-9 /-') : '';
$coloroption       = chess_sanitize(@$_POST['coloroption']);
$rated             = intval(@$_REQUEST['rated']);
$notify_accept     = isset($_POST['notify_accept']);
$notify_move       = isset($_POST['notify_move']);
$challenge_id      = intval(@$_REQUEST['challenge_id']);
$show_arbiter_ctrl = isset($_POST['show_arbiter_ctrl']);
$submit_challenge1 = isset($_POST['submit_challenge1']);
$submit_challenge2 = isset($_POST['submit_challenge2']);
$submit_challenge3 = isset($_POST['submit_challenge3']);
$cancel_challenge1 = isset($_POST['cancel_challenge1']);
$cancel_challenge2 = isset($_POST['cancel_challenge2']);
$cancel_challenge3 = isset($_POST['cancel_challenge3']);
$submit_accept     = isset($_POST['submit_accept']);
$cancel_accept     = isset($_POST['cancel_accept']);
$submit_delete     = isset($_POST['submit_delete']);
$confirm_delete    = intval(@$_POST['confirm_delete']);

// If form-submit, check security token.
if (($submit_challenge1 or $submit_challenge2 or $submit_challenge3 or $submit_accept or $submit_delete or $show_arbiter_ctrl) and is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check()) {
	redirect_header(XOOPS_URL . '/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE,
		_MD_CHESS_TOKEN_ERROR . '<br />' . implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
}

// If rating feature disabled, force ratings to off.
if (chess_moduleConfig('rating_system') == 'none') {
	$rated = 0;
}

$uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;

// Determine if user is a valid arbiter.
$is_arbiter = is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'));

if ($cancel_challenge1) {

	redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_SUCCESS, _TAKINGBACK);

} elseif ($cancel_challenge2) {

	chess_show_create_form1($gametype);

} elseif ($cancel_challenge3) {

	if ($gametype == _CHESS_GAMETYPE_OPEN or $gametype == _CHESS_GAMETYPE_USER) {
		chess_show_create_form2($gametype, $fen);
	} else {
		chess_show_create_form1($gametype, $fen);
	}

} elseif ($cancel_accept) {

	redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_SUCCESS, _TAKINGBACK);

} elseif ($submit_challenge1) {

	$fen_error = chess_fen_error($fen);
	if (!empty($fen_error)) {
		chess_show_create_form1($gametype, $fen, _MD_CHESS_FEN_INVALID . ': ' . $fen_error);
	} elseif ($gametype == _CHESS_GAMETYPE_OPEN or $gametype == _CHESS_GAMETYPE_USER) {
		chess_show_create_form2($gametype, $fen);
	} else {
		chess_show_create_form3($gametype, $fen, $coloroption, $opponent_uid, $rated);
	}

} elseif ($submit_challenge2) {

	if ($gametype == _CHESS_GAMETYPE_USER) {
		if (empty($opponent)) {
			chess_show_create_form2($gametype, $fen, $coloroption, $opponent_uid, $rated, _MD_CHESS_OPPONENT_MISSING);
		} elseif (!$opponent_uid) {
			chess_show_create_form2($gametype, $fen, $coloroption, $opponent_uid, $rated, _MD_CHESS_OPPONENT_INVALID);
		} elseif ($opponent_uid == $uid) {
			chess_show_create_form2($gametype, $fen, $coloroption, $opponent_uid, $rated, _MD_CHESS_OPPONENT_SELF);
		} else {
			chess_show_create_form3($gametype, $fen, $coloroption, $opponent_uid, $rated);
		}
	} else {
		chess_show_create_form3($gametype, $fen, $coloroption, $opponent_uid, $rated);
	}

} elseif ($submit_challenge3) {

	if ($gametype == _CHESS_GAMETYPE_OPEN) {
			chess_create_challenge($gametype, $fen, $coloroption, $rated, $notify_accept, $notify_move);
			redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_SUCCESS, _MD_CHESS_GAME_CREATED);
	} elseif ($gametype == _CHESS_GAMETYPE_USER) {
		if (empty($opponent)) {
			chess_show_create_form2($gametype, $fen, $coloroption, $opponent_uid, $rated, _MD_CHESS_OPPONENT_MISSING);
		} elseif (!$opponent_uid) {
			chess_show_create_form2($gametype, $fen, $coloroption, $opponent_uid, $rated, _MD_CHESS_OPPONENT_INVALID);
		} elseif ($opponent_uid == $uid) {
			chess_show_create_form2($gametype, $fen, $coloroption, $opponent_uid, $rated, _MD_CHESS_OPPONENT_SELF);
		} else {
			chess_create_challenge($gametype, $fen, $coloroption, $rated, $notify_accept, $notify_move, $opponent_uid);
			redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_SUCCESS, _MD_CHESS_GAME_CREATED);
		}
	} elseif ($gametype == _CHESS_GAMETYPE_SELF) {
		$game_id = chess_create_game($uid, $uid, $fen, $rated);
		redirect_header(XOOPS_URL . "/modules/chess/game.php?game_id=$game_id", _CHESS_REDIRECT_DELAY_SUCCESS, _MD_CHESS_GAME_CREATED);
	} else {
		chess_show_create_form1($gametype, $fen, _MD_CHESS_GAMETYPE_INVALID);
	}

} elseif ($submit_accept) {

	chess_accept_challenge($challenge_id, $coloroption, $notify_move);

} elseif ($submit_delete) {

	if ($confirm_delete) {
		if ($is_arbiter or chess_is_challenger($challenge_id)) {
			chess_delete_challenge($challenge_id);
			redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_SUCCESS, _MD_CHESS_GAME_DELETED);
		} else {
			redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE, _NOPERM);
		}
	} else {
		chess_show_delete_form($challenge_id, $show_arbiter_ctrl and $is_arbiter, _MD_CHESS_NO_CONFIRM_DELETE);
	}

} elseif ($challenge_id) {

	if (($show_arbiter_ctrl and $is_arbiter) or chess_is_challenger($challenge_id)) {
		chess_show_delete_form($challenge_id, $show_arbiter_ctrl and $is_arbiter);
	} else {
		chess_show_accept_form($challenge_id);
	}

} else {

	chess_show_create_form1($gametype);
}

require_once XOOPS_ROOT_PATH.'/footer.php';
/**#@-*/

/**
 * Generate form to get game type and optional FEN setup.
 *
 * @param string $gametype   _CHESS_GAMETYPE_OPEN, _CHESS_GAMETYPE_USER or _CHESS_GAMETYPE_SELF
 * @param string $fen        FEN setup
 * @param string $error_msg  Error message to display
 */
function chess_show_create_form1($gametype = _CHESS_GAMETYPE_OPEN, $fen = '', $error_msg = '')
{
	$form = new XoopsThemeForm(_MD_CHESS_CREATE_FORM, 'create_form1', 'create.php', 'post', true);

	if ($error_msg) {
		$form->addElement(new XoopsFormLabel(_MD_CHESS_ERROR . ': ', '<div class="errorMsg">' . $error_msg . '</div>'));
	}

	$menu_gametype = new XoopsFormSelect(_MD_CHESS_LABEL_GAMETYPE . ':', 'gametype', $gametype, 1, false);
	$menu_gametype->addOption(_CHESS_GAMETYPE_OPEN, _MD_CHESS_MENU_GAMETYPE_OPEN);
	$menu_gametype->addOption(_CHESS_GAMETYPE_USER, _MD_CHESS_MENU_GAMETYPE_USER);
	$menu_gametype->addOption(_CHESS_GAMETYPE_SELF, _MD_CHESS_MENU_GAMETYPE_SELF);
	$form->addElement($menu_gametype);

	if (chess_moduleConfig('allow_setup')) {
		$form->addElement(new XoopsFormLabel('', '&nbsp;'));
		$form->addElement(new XoopsFormLabel('', _MD_CHESS_LABEL_FEN_EXPLAIN));
		$form->addElement(new XoopsFormText(_MD_CHESS_LABEL_FEN_SETUP . ':', 'fen', 80, _CHESS_TEXTBOX_FEN_MAXLEN, $fen));
	}

	$form->addElement(new XoopsFormLabel('&nbsp;', '&nbsp;'));

	$buttons = new XoopsFormElementTray('');
	$buttons->addElement(new XoopsFormButton('', 'submit_challenge1', _MD_CHESS_CREATE_SUBMIT, 'submit'));
	$buttons->addElement(new XoopsFormButton('', 'cancel_challenge1', _MD_CHESS_CREATE_CANCEL, 'submit'));
	$form->addElement($buttons);

	$form->display();
}

/**
 * Generate form to get color and rating options and, if game type is _CHESS_GAMETYPE_USER (Individual challenge), get opponent.
 *
 * @param string $gametype      _CHESS_GAMETYPE_OPEN, _CHESS_GAMETYPE_USER or _CHESS_GAMETYPE_SELF
 * @param string $fen           FEN setup
 * @param string $coloroption   _CHESS_COLOROPTION_OPPONENT, _CHESS_COLOROPTION_RANDOM, _CHESS_COLOROPTION_WHITE or _CHESS_COLOROPTION_BLACK
 * @param int    $opponent_uid  Opponent's user ID ('0' for open challenge)
 * @param int    $rated         '1' if rated, '0' if not rated
 * @param string $error_msg     Error message to display
 */
function chess_show_create_form2($gametype, $fen, $coloroption = _CHESS_COLOROPTION_OPPONENT, $opponent_uid = 0, $rated = 1, $error_msg = '')
{
	$form = new XoopsThemeForm(_MD_CHESS_CREATE_FORM, 'create_form2', 'create.php', 'post', true);

	$form->addElement(new XoopsFormHidden('gametype', $gametype));
	$form->addElement(new XoopsFormHidden('fen',      $fen));

	if ($error_msg) {
		$form->addElement(new XoopsFormLabel(_MD_CHESS_ERROR . ':', '<div class="errorMsg">' . $error_msg . '</div>'));
	}

	$member_handler    =& xoops_gethandler('member');
	$opponent_user     =& $member_handler->getUser($opponent_uid);
	$opponent_username =  is_object($opponent_user) ? $opponent_user->getVar('uname') : '';

	if ($gametype == _CHESS_GAMETYPE_USER) {
		$form->addElement(new XoopsFormText(_MD_CHESS_LABEL_OPPONENT . ':', 'opponent', _CHESS_TEXTBOX_OPPONENT_SIZE,
			_CHESS_TEXTBOX_OPPONENT_MAXLEN, $opponent_username));
	}

	$radio_color = new XoopsFormRadio(_MD_CHESS_LABEL_COLOR . ':', 'coloroption', $coloroption);
	$radio_color->addOption(_CHESS_COLOROPTION_OPPONENT, _MD_CHESS_RADIO_COLOR_OPPONENT);
	$radio_color->addOption(_CHESS_COLOROPTION_RANDOM,   _MD_CHESS_RADIO_COLOR_RANDOM);
	$radio_color->addOption(_CHESS_COLOROPTION_WHITE,    _MD_CHESS_RADIO_COLOR_WHITE);
	$radio_color->addOption(_CHESS_COLOROPTION_BLACK,    _MD_CHESS_RADIO_COLOR_BLACK);
	$form->addElement($radio_color);

	if (chess_moduleConfig('rating_system') !== 'none') {
		if ($gametype == _CHESS_GAMETYPE_OPEN or $gametype == _CHESS_GAMETYPE_USER) {
			if (chess_moduleConfig('allow_unrated_games')) {
				$radio_rated = new XoopsFormRadio(_MD_CHESS_RATED_GAME . ':', 'rated', $rated);
				$radio_rated->addOption(1, _YES);
				$radio_rated->addOption(0, _NO);
				$form->addElement($radio_rated);
			} else {
				$form->addElement(new XoopsFormHidden('rated', $rated));
			}
		}
	} else {
		$form->addElement(new XoopsFormHidden('rated', 0));
	}

	$buttons = new XoopsFormElementTray('');
	$buttons->addElement(new XoopsFormButton('', 'submit_challenge2', _MD_CHESS_CREATE_SUBMIT, 'submit'));
	$buttons->addElement(new XoopsFormButton('', 'cancel_challenge2', _MD_CHESS_CREATE_CANCEL, 'submit'));
	$form->addElement($buttons);

	$form->display();
}

/**
 * Generate form to get confirmation of a new challenge.
 *
 * @param string $gametype      _CHESS_GAMETYPE_OPEN, _CHESS_GAMETYPE_USER or _CHESS_GAMETYPE_SELF
 * @param string $fen           FEN setup
 * @param string $coloroption   _CHESS_COLOROPTION_OPPONENT, _CHESS_COLOROPTION_RANDOM, _CHESS_COLOROPTION_WHITE or _CHESS_COLOROPTION_BLACK
 * @param int    $opponent_uid  Opponent's user ID ('0' for open challenge)
 * @param int    $rated         '1' if rated, '0' if not rated
 */
function chess_show_create_form3($gametype, $fen, $coloroption, $opponent_uid, $rated)
{
	$member_handler    =& xoops_gethandler('member');
	$opponent_user     =& $member_handler->getUser($opponent_uid);
	$opponent_username =  is_object($opponent_user) ? $opponent_user->getVar('uname') : '';

	$form = new XoopsThemeForm(_MD_CHESS_CREATE_FORM, 'create_form3', 'create.php', 'post', true);

	$form->addElement(new XoopsFormHidden('gametype',    $gametype));
	$form->addElement(new XoopsFormHidden('fen',         $fen));
	$form->addElement(new XoopsFormHidden('opponent',    $opponent_username));
	$form->addElement(new XoopsFormHidden('coloroption', $coloroption));
	$form->addElement(new XoopsFormHidden('rated',       $rated));

	$form->addElement(new XoopsFormLabel('', '<div class="confirmMsg">' . _MD_CHESS_GAME_CONFIRM . '</div>'));

	switch($gametype) {
		case _CHESS_GAMETYPE_OPEN:
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_OPEN;
			break;
		case _CHESS_GAMETYPE_USER:
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_USER;
			break;
		case _CHESS_GAMETYPE_SELF:
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_SELF;
			break;
		default:
			$label_gametype = _MD_CHESS_LABEL_ERROR;
			break;
	}
	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_GAMETYPE . ':', $label_gametype));

	if (!empty($fen)) {
		$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_FEN_SETUP . ':', $fen));
	}

	if ($gametype == _CHESS_GAMETYPE_USER) {

		$member_handler    =& xoops_gethandler('member');
		$opponent_user     =& $member_handler->getUser($opponent_uid);
		$opponent_username =  is_object($opponent_user) ? $opponent_user->getVar('uname') : '';

		$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_OPPONENT . ':', $opponent_username));
	}

	if ($gametype == _CHESS_GAMETYPE_OPEN or $gametype == _CHESS_GAMETYPE_USER) {

		switch($coloroption) {
			case _CHESS_COLOROPTION_OPPONENT:
				$label_coloroption = _MD_CHESS_RADIO_COLOR_OPPONENT;
				break;
			case _CHESS_COLOROPTION_RANDOM:
				$label_coloroption = _MD_CHESS_RADIO_COLOR_RANDOM;
				break;
			case _CHESS_COLOROPTION_WHITE:
				$label_coloroption = _MD_CHESS_RADIO_COLOR_WHITE;
				break;
			case _CHESS_COLOROPTION_BLACK:
				$label_coloroption = _MD_CHESS_RADIO_COLOR_BLACK;
				break;
			default:
				$label_coloroption = _MD_CHESS_LABEL_ERROR;
				break;
		}
		$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_COLOR . ':', $label_coloroption));

		if (chess_moduleConfig('rating_system') != 'none') {
			$form->addElement(new XoopsFormLabel(_MD_CHESS_RATED_GAME . ':', $rated ? _YES : _NO));
		}

		// Determine whether current user is subscribed to receive a notification when his challenge is accepted.
		global $xoopsModule, $xoopsUser;
		$uid = $xoopsUser->getVar('uid');
		$mid = $xoopsModule->getVar('mid');
		$notification_handler =& xoops_gethandler('notification');
		$is_subscribed = $notification_handler->isSubscribed('global', 0, 'notify_accept_challenge', $mid, $uid) != 0;

		// Display checkbox with checked-state reflecting subscription status.
		$checked_value = 1;
		$checkbox_notify_acpt_chal = new XoopsFormCheckBox('', 'notify_accept', $is_subscribed ? $checked_value : null);
		$checkbox_notify_acpt_chal->addOption($checked_value, _MD_CHESS_NEVT_ACPT_CHAL_CAP);
		$form->addElement($checkbox_notify_acpt_chal);

		// Display checkbox, initially checked.
		$checked_value = 1;
		$checkbox_notify_move = new XoopsFormCheckBox('', 'notify_move', $checked_value);
		$checkbox_notify_move->addOption($checked_value, _MD_CHESS_NEVT_MOVE_CAP);
		$form->addElement($checkbox_notify_move);
	}

	$buttons = new XoopsFormElementTray('');
	$buttons->addElement(new XoopsFormButton('', 'submit_challenge3', _MD_CHESS_CREATE_SUBMIT, 'submit'));
	$buttons->addElement(new XoopsFormButton('', 'cancel_challenge3', _MD_CHESS_CREATE_CANCEL, 'submit'));
	$form->addElement($buttons);

	$form->display();
}

/**
 * Generate form to get acceptance of a challenge.
 *
 * @param int $challenge_id  Challenge ID
 */
function chess_show_accept_form($challenge_id)
{
	global $xoopsDB, $xoopsUser;

	$challenges_table = $xoopsDB->prefix('chess_challenges');

	 $result = $xoopsDB->query(trim("
		SELECT game_type, fen, color_option, player1_uid, player2_uid, UNIX_TIMESTAMP(create_date) as create_date, is_rated
		FROM   $challenges_table
		WHERE  challenge_id = '$challenge_id'
	"));

	if ($xoopsDB->getRowsNum($result) < 1) {
		redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_GAME_NOT_FOUND);
	}

	$row = $xoopsDB->fetchArray($result);

	$xoopsDB->freeRecordSet($result);

	$form = new XoopsThemeForm(_MD_CHESS_ACCEPT_FORM, 'accept_form', 'create.php', 'post', true);

	$form->addElement(new XoopsFormHidden('challenge_id',   $challenge_id));

	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_DATE_CREATED . ':', formatTimestamp($row['create_date'], "m")));

	$member_handler =& xoops_gethandler('member');

	switch($row['game_type']) {
		case _CHESS_GAMETYPE_OPEN:
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_OPEN;
			break;
		case _CHESS_GAMETYPE_USER:
			$player2_user     =& $member_handler->getUser($row['player2_uid']);
			$player2_username =  is_object($player2_user) ? $player2_user->getVar('uname') : '?';
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_USER . ': ' . $player2_username;
			break;
		case _CHESS_GAMETYPE_SELF:
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_SELF;
			break;
		default:
			$label_gametype = _MD_CHESS_LABEL_ERROR;
			break;
	}
	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_GAMETYPE . ':', $label_gametype));

	$player1_user     =& $member_handler->getUser($row['player1_uid']);
	$player1_username =  is_object($player1_user) ? $player1_user->getVar('uname') : '?';
	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_CHALLENGER . ':',
		"<a href='" .XOOPS_URL. "/modules/chess/player_stats.php?player_uid={$row['player1_uid']}'>$player1_username</a>"
	));

	$player2_username =  $xoopsUser ? $xoopsUser->getVar('uname') : '?';
	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_OPPONENT . ':', $player2_username));

	if (!empty($row['fen'])) {
		$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_FEN_SETUP . ':', $row['fen']));
	}

	if ($row['color_option'] == _CHESS_COLOROPTION_OPPONENT) {
		$radio_color = new XoopsFormRadio(_MD_CHESS_LABEL_COLOR . ':', 'coloroption', _CHESS_COLOROPTION_RANDOM);
		$radio_color->addOption(_CHESS_COLOROPTION_RANDOM,   _MD_CHESS_RADIO_COLOR_RANDOM);
		$radio_color->addOption(_CHESS_COLOROPTION_WHITE,    _MD_CHESS_RADIO_COLOR_WHITE);
		$radio_color->addOption(_CHESS_COLOROPTION_BLACK,    _MD_CHESS_RADIO_COLOR_BLACK);
		$form->addElement($radio_color);
	} else {
		switch ($row['color_option']) {
			case _CHESS_COLOROPTION_RANDOM:
				$label_coloroption = _MD_CHESS_RADIO_COLOR_RANDOM;
				break;
			case _CHESS_COLOROPTION_WHITE:
				$label_coloroption = _MD_CHESS_RADIO_COLOR_BLACK; // player1 white, player2 black
				break;
			case _CHESS_COLOROPTION_BLACK:
				$label_coloroption = _MD_CHESS_RADIO_COLOR_WHITE; // player1 black, player2 white
				break;
			default:
				$label_coloroption = _MD_CHESS_LABEL_ERROR;
				break;
		}
		$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_COLOR . ':', $label_coloroption));
	}

	if (chess_moduleConfig('rating_system') != 'none') {
		$form->addElement(new XoopsFormLabel(_MD_CHESS_RATED_GAME . ':', $row['is_rated'] ? _YES : _NO));
	}

	// Display notification-subscribe checkbox, initially checked.
	$checked_value = 1;
	$checkbox_notify_move = new XoopsFormCheckBox('', 'notify_move', $checked_value);
	$checkbox_notify_move->addOption($checked_value, _MD_CHESS_NEVT_MOVE_CAP);
	$form->addElement($checkbox_notify_move);

	$tray = new XoopsFormElementTray('');
	$tray->addElement(new XoopsFormButton('', 'submit_accept', _MD_CHESS_CREATE_ACCEPT, 'submit'));
	$tray->addElement(new XoopsFormButton('', 'cancel_accept', _MD_CHESS_CREATE_CANCEL, 'submit'));
	$form->addElement($tray);

	$form->display();
}

/**
 * Generate form to delete challenge.
 *
 * @param int    $challenge_id       Challenge ID
 * @param bool   $show_arbiter_ctrl  True if form generated from admin page
 * @param string $error_msg          Error message to display
 */
function chess_show_delete_form($challenge_id, $show_arbiter_ctrl, $error_msg = '')
{
	global $xoopsDB;

	$challenges_table = $xoopsDB->prefix('chess_challenges');

	 $result = $xoopsDB->query(trim("
		SELECT game_type, fen, color_option, player1_uid, player2_uid, UNIX_TIMESTAMP(create_date) as create_date, is_rated
		FROM   $challenges_table
		WHERE  challenge_id = '$challenge_id'
	"));

	if ($xoopsDB->getRowsNum($result) < 1) {
		redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_GAME_NOT_FOUND);
	}

	$row = $xoopsDB->fetchArray($result);

	$xoopsDB->freeRecordSet($result);

	$form = new XoopsThemeForm(_MD_CHESS_DELETE_FORM, 'delete_form', 'create.php', 'post', true);

	$form->addElement(new XoopsFormHidden('challenge_id',   $challenge_id));

	if ($show_arbiter_ctrl) {
		$form->addElement(new XoopsFormHidden('show_arbiter_ctrl', $show_arbiter_ctrl));
	}

	if ($error_msg) {
		$form->addElement(new XoopsFormLabel(_MD_CHESS_ERROR . ': ', '<div class="errorMsg">' . $error_msg . '</div>'));
	}

	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_DATE_CREATED . ':', formatTimestamp($row['create_date'], "m")));

	$member_handler =& xoops_gethandler('member');

	switch($row['game_type']) {
		case _CHESS_GAMETYPE_OPEN:
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_OPEN;
			break;
		case _CHESS_GAMETYPE_USER:
			$player2_user     =& $member_handler->getUser($row['player2_uid']);
			$player2_username =  is_object($player2_user) ? $player2_user->getVar('uname') : '?';
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_USER . ': ' . $player2_username;
			break;
		case _CHESS_GAMETYPE_SELF:
			$label_gametype = _MD_CHESS_LABEL_GAMETYPE_SELF;
			break;
		default:
			$label_gametype = _MD_CHESS_LABEL_ERROR;
			break;
	}
	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_GAMETYPE . ':', $label_gametype));

	$player1_user     =& $member_handler->getUser($row['player1_uid']);
	$player1_username =  is_object($player1_user) ? $player1_user->getVar('uname') : '?';
	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_CHALLENGER . ':',  $player1_username));

	if (!empty($row['fen'])) {
		$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_FEN_SETUP . ':', $row['fen']));
	}

	switch($row['color_option']) {
		case _CHESS_COLOROPTION_OPPONENT:
			$label_coloroption = _MD_CHESS_RADIO_COLOR_OPPONENT;
			break;
		case _CHESS_COLOROPTION_RANDOM:
			$label_coloroption = _MD_CHESS_RADIO_COLOR_RANDOM;
			break;
		case _CHESS_COLOROPTION_WHITE:
			$label_coloroption = _MD_CHESS_RADIO_COLOR_WHITE;
			break;
		case _CHESS_COLOROPTION_BLACK:
			$label_coloroption = _MD_CHESS_RADIO_COLOR_BLACK;
			break;
		default:
			$label_coloroption = _MD_CHESS_LABEL_ERROR;
			break;
	}
	$form->addElement(new XoopsFormLabel(_MD_CHESS_LABEL_COLOR . ':', $label_coloroption));

	if (chess_moduleConfig('rating_system') != 'none') {
		$form->addElement(new XoopsFormLabel(_MD_CHESS_RATED_GAME . ':', $row['is_rated'] ? _YES : _NO));
	}

	// Display confirm-delete checkbox, initially unchecked.
	$checked_value = 1;
	$checkbox_confirm_delete = new XoopsFormCheckBox('', 'confirm_delete', !$checked_value);
	$checkbox_confirm_delete->addOption($checked_value, _MD_CHESS_CONFIRM_DELETE);

	$tray = new XoopsFormElementTray('');
	$tray->addElement(new XoopsFormButton('', 'submit_delete', _MD_CHESS_CREATE_DELETE, 'submit'));
	$tray->addElement($checkbox_confirm_delete);
	$form->addElement($tray);

	$form->display();
}

/**
 * Accept a challenge.
 *
 * @param int    $challenge_id         Challenge ID
 * @param string $coloroption          _CHESS_COLOROPTION_OPPONENT, _CHESS_COLOROPTION_RANDOM, _CHESS_COLOROPTION_WHITE or _CHESS_COLOROPTION_BLACK
 * @param bool   $notify_move_player2  If true, subscribe the accepter to receive a notification when a new move is made.
 */
function chess_accept_challenge($challenge_id, $coloroption, $notify_move_player2 = false)
{
	global $xoopsDB, $xoopsUser;

	$challenges_table = $xoopsDB->prefix('chess_challenges');

	$result = $xoopsDB->query(trim("
		SELECT game_type, fen, color_option, notify_move_player1, player1_uid, player2_uid, UNIX_TIMESTAMP(create_date) as create_date, is_rated
		FROM   $challenges_table
		WHERE  challenge_id = '$challenge_id'
	"));

	if ($xoopsDB->getRowsNum($result) < 1) {
		redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_GAME_NOT_FOUND);
	}

	$row = $xoopsDB->fetchArray($result);

	$xoopsDB->freeRecordSet($result);

	$uid = $xoopsUser ? $xoopsUser->getVar('uid') : 0;

	if ($row['game_type'] == _CHESS_GAMETYPE_USER and $uid != $row['player2_uid']) {
		redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_WRONG_PLAYER2);
	} elseif ($uid == $row['player1_uid']) {
		redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_SAME_PLAYER2);
	}

	switch ($row['color_option']) {

		case _CHESS_COLOROPTION_OPPONENT:

			switch ($coloroption) {

				default:
				case _CHESS_COLOROPTION_RANDOM:
					if (mt_rand(1, 2) == 1) {
						$white_uid = $row['player1_uid'];
						$black_uid = $uid;
					} else {
						$white_uid = $uid;
						$black_uid = $row['player1_uid'];
					}
					break;

				case _CHESS_COLOROPTION_WHITE:
					$white_uid = $uid;
					$black_uid = $row['player1_uid'];
					break;

				case _CHESS_COLOROPTION_BLACK:
					$white_uid = $row['player1_uid'];
					$black_uid = $uid;
					break;
			}
			break;

		default:
		case _CHESS_COLOROPTION_RANDOM:
			if (mt_rand(1, 2) == 1) {
				$white_uid = $row['player1_uid'];
				$black_uid = $uid;
			} else {
				$white_uid = $uid;
				$black_uid = $row['player1_uid'];
			}
			break;

		case _CHESS_COLOROPTION_WHITE:
			$white_uid = $row['player1_uid'];
			$black_uid = $uid;
			break;

		case _CHESS_COLOROPTION_BLACK:
			$white_uid = $uid;
			$black_uid = $row['player1_uid'];
			break;
	}

	$game_id = chess_create_game($white_uid, $black_uid, $row['fen'], $row['is_rated'], $row['notify_move_player1'] ? $row['player1_uid'] : 0, $notify_move_player2);

	$xoopsDB->query("DELETE FROM $challenges_table WHERE challenge_id = '$challenge_id'");
	if ($xoopsDB->errno()) {
		trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);
	}

	// Notify player 1 that his challenge has been accepted (if he has subscribed to the notification).
	$player2_username = $xoopsUser ? $xoopsUser->getVar('uname') : '*unknown*';
	$notification_handler =& xoops_gethandler('notification');
	$extra_tags = array('CHESS_PLAYER' => $player2_username, 'CHESS_GAME_ID' => $game_id);
	$notification_handler->triggerEvent('global', 0, 'notify_accept_challenge', $extra_tags, array($row['player1_uid']));

	redirect_header(XOOPS_URL . "/modules/chess/game.php?game_id=$game_id", _CHESS_REDIRECT_DELAY_SUCCESS, _MD_CHESS_GAME_CREATED);
}

/**
 * Determine whether current user offered the specified challenge.
 *
 * @param int $challenge_id  Challenge ID
 * @return bool
 */
function chess_is_challenger($challenge_id)
{
	global $xoopsDB, $xoopsUser;

	$challenges_table = $xoopsDB->prefix('chess_challenges');

	$result = $xoopsDB->query("SELECT player1_uid FROM $challenges_table WHERE challenge_id = '$challenge_id'");

	if ($xoopsDB->getRowsNum($result) < 1) {
		redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_GAME_NOT_FOUND);
	}

	$row = $xoopsDB->fetchArray($result);

	$xoopsDB->freeRecordSet($result);

	$uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;

	return $uid == $row['player1_uid'];
}

/**
 * Create a new challenge in the database.
 *
 * @param string $gametype             _CHESS_GAMETYPE_OPEN, _CHESS_GAMETYPE_USER or _CHESS_GAMETYPE_SELF
 * @param string $fen                  FEN setup
 * @param string $coloroption          _CHESS_COLOROPTION_OPPONENT, _CHESS_COLOROPTION_RANDOM, _CHESS_COLOROPTION_WHITE or _CHESS_COLOROPTION_BLACK
 * @param int    $rated                '1' if rated, '0' if not rated
 * @param bool   $notify_accept        Subscribe/unsubscribe the challenger for receiving a notification when the challenge is accepted.
 * @param bool   $notify_move_player1  If true, subscribe the challenger to receive a notification when a new move is made.
 * @param int    $opponent_uid         Opponent's user ID ('0' for open challenge)
 */
function chess_create_challenge($gametype, $fen, $coloroption, $rated, $notify_accept, $notify_move_player1, $opponent_uid = 0)
{
	#$where = __CLASS__ . '::' . __FUNCTION__;#*#DEBUG#
	#echo "In $where\n";#*#DEBUG#

	global $xoopsUser;
	$uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;

	$myts = myTextSanitizer::getInstance();
	$fen_q = $myts->addslashes($fen);

	#trigger_error("inserting new game'", E_USER_NOTICE);#*#DEBUG#

	global $xoopsDB;

	$table = $xoopsDB->prefix('chess_challenges');

	$xoopsDB->query(trim("
		INSERT INTO $table
		SET
			game_type           = '$gametype',
			fen                 = '$fen_q',
			color_option        = '$coloroption',
			notify_move_player1 = '$notify_move_player1',
			player1_uid         = '$uid',
			player2_uid         = '$opponent_uid',
			create_date         = NOW(),
			is_rated            = '$rated'
	"));
	if ($xoopsDB->errno()) {
		trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);
	}

	$challenge_id = $xoopsDB->getInsertId();

	$notification_handler =& xoops_gethandler('notification');

	// Update the challenger's subscription for receiving a notification when the challenge is accepted.
	if ($notify_accept) {
		$notification_handler->subscribe  ('global', 0, 'notify_accept_challenge');
	} else {
		$notification_handler->unsubscribe('global', 0, 'notify_accept_challenge');
	}

	// Notify any subscribers that a challenge has been offered.
	$player1_username = $xoopsUser ? $xoopsUser->getVar('uname') : '*unknown*';
	$extra_tags = array('CHESS_CHALLENGER' => $player1_username, 'CHESS_CHALLENGE_ID' => $challenge_id);
	if ($gametype == _CHESS_GAMETYPE_OPEN) {
		$notification_handler->triggerEvent('global', 0, 'notify_challenge_open', $extra_tags);
	} elseif ($gametype == _CHESS_GAMETYPE_USER) {
		$notification_handler->triggerEvent('global', 0, 'notify_challenge_user', $extra_tags, array($opponent_uid));
	}
}

/**
 * Delete a challenge from the database.
 *
 * @param int $challenge_id  Challenge ID
 */
function chess_delete_challenge($challenge_id)
{
	global $xoopsDB;

	$table = $xoopsDB->prefix('chess_challenges');

	$xoopsDB->query("DELETE FROM $table WHERE challenge_id='$challenge_id'");
	if ($xoopsDB->errno()) {
		trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);
	}
}

/**
 * Create a new game in the database.
 *
 * @param int    $white_uid                White's user ID
 * @param int    $black_uid                Black's user ID
 * @param string $fen                      FEN setup
 * @param int    $rated                    '1' if rated, '0' if not rated
 * @param int    $notify_move_player1_uid  If nonzero, subscribe the challenger to receive a notification when a new move is made.
 * @param bool   $notify_move_player2      If true, subscribe the accepter to receive a notification when a new move is made.
 */
function chess_create_game($white_uid, $black_uid, $fen, $rated, $notify_move_player1_uid = 0, $notify_move_player2 = false)
{
	#$where = __CLASS__ . '::' . __FUNCTION__;#*#DEBUG#
	#echo "In $where\n";#*#DEBUG#
	#var_dump('white_uid', $white_uid, 'black_uid', $black_uid);#*#DEBUG#

	require_once XOOPS_ROOT_PATH.'/modules/chess/class/chessgame.inc.php';

	$chessgame = new ChessGame($fen);
	empty($chessgame->error) or trigger_error('chessgame invalid', E_USER_ERROR);
	$gamestate = $chessgame->gamestate();
	is_array($gamestate) or trigger_error('gamestate invalid', E_USER_ERROR);

	#trigger_error("inserting new game'", E_USER_NOTICE);#*#DEBUG#

	$myts = myTextSanitizer::getInstance();
	$fen_q = $myts->addslashes($fen);

	global $xoopsDB;

	$table = $xoopsDB->prefix('chess_games');

	$xoopsDB->query(trim("
		INSERT INTO $table
		SET
			white_uid                    = '$white_uid',
			black_uid                    = '$black_uid',
			create_date                  = NOW(),
			start_date                   = '0000-00-00 00:00:00',
			last_date                    = '0000-00-00 00:00:00',
			fen_piece_placement          = '{$gamestate['fen_piece_placement']}',
			fen_active_color             = '{$gamestate['fen_active_color']}',
			fen_castling_availability    = '{$gamestate['fen_castling_availability']}',
			fen_en_passant_target_square = '{$gamestate['fen_en_passant_target_square']}',
			fen_halfmove_clock           = '{$gamestate['fen_halfmove_clock']}',
			fen_fullmove_number          = '{$gamestate['fen_fullmove_number']}',
			pgn_fen                      = '$fen_q',
			pgn_result                   = '{$gamestate['pgn_result']}',
			pgn_movetext                 = '{$gamestate['pgn_movetext']}',
			is_rated                     = '$rated'
	"));
	if ($xoopsDB->errno()) {
		trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);
	}

	$game_id = $xoopsDB->getInsertId();

	$notification_handler =& xoops_gethandler('notification');

	// If requested, subscribe the challenger to receive a notification when a new move is made.
	if ($notify_move_player1_uid) {
		$notification_handler->subscribe('game', $game_id, 'notify_game_move', null, null, $notify_move_player1_uid);
	}

	// If requested, subscribe the accepter to receive a notification when a new move is made.
	if ($notify_move_player2) {
		$notification_handler->subscribe('game', $game_id, 'notify_game_move');
	}

	return $game_id;
}

/**
 * Check whether a FEN setup is valid.
 *
 * @param string $fen  FEN setup
 * @return string  Empty string if FEN setup is valid, otherwise contains error message.
*/
function chess_fen_error($fen)
{
	if (!empty($fen)) {
		require_once XOOPS_ROOT_PATH . '/modules/chess/class/chessgame.inc.php';
		$chessgame = new ChessGame($fen);
		$fen_error = $chessgame->error;
	} else {
		$fen_error = '';
	}

	return $fen_error;
}

/**
 * Get user ID of specified chess opponent.
 *
 * This function is used to check whether the specified opponent is available, when offering an individual challenge.
 *
 * @param string $username  Opponent's username
 * @return int Opponent's user ID if opponent is registered and allowed to play chess, otherwise zero.
 */
function chess_opponent_uid($username)
{
	$uid = chess_uname_to_uid($username);
	$can_play = ($uid > 0) ? chess_can_play($uid) : false;
	return $can_play ? $uid : 0;
}

?>