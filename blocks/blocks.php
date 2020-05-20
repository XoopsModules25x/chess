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

require_once XOOPS_ROOT_PATH . '/modules/chess/include/constants.inc.php';

// ----------------------------------
/**
 * @param $options
 * @return array
 */
function b_chess_games_show($options)
{
	global $xoopsModule, $xoopsDB;

	// don't display this block within owning module
	if (is_object($xoopsModule) and $xoopsModule->getVar('dirname') == 'chess') {
		return [];
	}

	$block = [];

	$table = $xoopsDB->prefix('chess_games');

	$limit = intval($options[0]); // sanitize with intval()

	switch($options[1]) {
		case 1:
			$where = "pgn_result = '*'";
			break;
		case 2:
			$where = "pgn_result != '*'";
			break;
		default:
			$where = 1;
			break;
	}

	$result = $xoopsDB->query(trim("
		SELECT   game_id, fen_active_color, white_uid, black_uid, pgn_result, UNIX_TIMESTAMP(create_date) AS create_date,
		         UNIX_TIMESTAMP(start_date) AS start_date, UNIX_TIMESTAMP(last_date) AS last_date
		FROM     $table
		WHERE    $where
		ORDER BY last_date DESC, start_date DESC, create_date DESC
		LIMIT    $limit
	"));

	$block          = [];
	$block['games'] = [];

	$member_handler = xoops_getHandler('member');

	// usort-function for sorting array in descending order of 'date' value
	$cmp_func = create_function('$a,$b', "return (\$a['date'] == \$b['date'] ? 0 : (\$a['date'] < \$b['date'] ? 1 : -1));"); 

 	while ($row = $xoopsDB->fetchArray($result)) {

		$user_white     = $member_handler->getUser($row['white_uid']);
		$username_white =  is_object($user_white) ? $user_white->getVar('uname') : '(open)';

		$user_black     = $member_handler->getUser($row['black_uid']);
		$username_black =  is_object($user_black) ? $user_black->getVar('uname') : '(open)';

		$date = max($row['create_date'], $row['start_date'], $row['last_date']);

		$games[] = [
			'game_id'          => $row['game_id'],
			'username_white'   => $username_white,
			'username_black'   => $username_black,
			'date'             => $date,
			'fen_active_color' => $row['fen_active_color'],
			'pgn_result'       => $row['pgn_result'],
        ];

	}

	$xoopsDB->freeRecordSet($result);

	// sorting $games in descending order of 'date' value
	usort($games, $cmp_func);

	$block['games'] = $games;

	$block['date_format'] = _SHORTDATESTRING;

	return $block;
}

// ------------------------------------------
/**
 * @param $options
 * @return array
 */
function b_chess_challenges_show($options)
{
	global $xoopsModule, $xoopsDB;

	// don't display this block within owning module
	if (is_object($xoopsModule) and $xoopsModule->getVar('dirname') == 'chess') {
		return [];
	}

	$table = $xoopsDB->prefix('chess_challenges');

	$limit = intval($options[0]); // sanitize with intval()

	switch($options[1]) {
		case 1:
			$where = "game_type = 'open'";
			break;
		case 2:
			$where = "game_type = 'user'";
			break;
		default:
			$where = 1;
			break;
	}

	$result = $xoopsDB->query(trim("
		SELECT   challenge_id, game_type, player1_uid, player2_uid, UNIX_TIMESTAMP(create_date) AS create_date
		FROM     $table
		WHERE    $where
		ORDER BY create_date DESC
		LIMIT    $limit
	"));

	$block               = [];
	$block['challenges'] = [];

	$member_handler = xoops_getHandler('member');

 	while ($row = $xoopsDB->fetchArray($result)) {

		$user_player1     = $member_handler->getUser($row['player1_uid']);
		$username_player1 =  is_object($user_player1) ? $user_player1->getVar('uname') : '?';

		$user_player2     = $member_handler->getUser($row['player2_uid']);
		$username_player2 =  is_object($user_player2) ? $user_player2->getVar('uname') : '?';

		$block['challenges'][] = [
			'challenge_id'     => $row['challenge_id'],
			'game_type'        => $row['game_type'],
			'username_player1' => $username_player1,
			'username_player2' => $username_player2,
			'create_date'      => $row['create_date'],
        ];
	}

	$xoopsDB->freeRecordSet($result);

	$block['date_format'] = _SHORTDATESTRING;

	return $block;
}

// -----------------------------------
/**
 * @param $options
 * @return string
 */
function b_chess_games_edit($options)
{
	$show_inplay    = $options[1] == 1 ? "checked='checked'" : '';
	$show_concluded = $options[1] == 2 ? "checked='checked'" : '';
	$show_both      = $options[1] == 3 ? "checked='checked'" : '';

	$form = "
		"._MB_CHESS_NUM_GAMES.": <input type='text' name='options[0]' value='{$options[0]}' size='3' maxlength='3' />
		<br />
		<input type='radio' name='options[1]' value='1' $show_inplay    /> "._MB_CHESS_SHOW_GAMES_INPLAY."
		<input type='radio' name='options[1]' value='2' $show_concluded /> "._MB_CHESS_SHOW_GAMES_CONCLUDED."
		<input type='radio' name='options[1]' value='3' $show_both      /> "._MB_CHESS_SHOW_GAMES_BOTH."
	";

	return $form;
}

// ------------------------------------------
/**
 * @param $options
 * @return string
 */
function b_chess_challenges_edit($options)
{
	$show_open = $options[1] == 1 ? "checked='checked'" : '';
	$show_user = $options[1] == 2 ? "checked='checked'" : '';
	$show_both = $options[1] == 3 ? "checked='checked'" : '';

	$form = "
		"._MB_CHESS_NUM_CHALLENGES.": <input type='text' name='options[0]' value='{$options[0]}' size='3' maxlength='3' />
		<br />
		<input type='radio' name='options[1]' value='1' $show_open /> "._MB_CHESS_SHOW_CHALLENGES_OPEN."
		<input type='radio' name='options[1]' value='2' $show_user /> "._MB_CHESS_SHOW_CHALLENGES_USER."
		<input type='radio' name='options[1]' value='3' $show_both /> "._MB_CHESS_SHOW_CHALLENGES_BOTH."
	";

	return $form;
}

?>
