<?php
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
 * Ratings functions.
 *
 * @package chess
 * @subpackage ratings
 */

/**#@+
 */
require_once XOOPS_ROOT_PATH . '/modules/chess/include/functions.inc.php';
/**#@-*/

/**
 * Update the players' ratings for the specified game.
 *
 * @param int $gid  Game ID
 * @return bool  True if ratings updated, otherwise false
 */
function chess_ratings_adj($gid)
{
	global $xoopsDB;

	$rating_system = chess_moduleConfig('rating_system');
	$init_rating   = chess_moduleConfig('initial_rating');

	if ($rating_system == 'none') {
		return false;
	}

	// determine function for calculating new ratings using configured rating system
	$func = chess_ratings_get_func_adj($rating_system);

	$games_table   = $xoopsDB->prefix('chess_games');
	$ratings_table = $xoopsDB->prefix('chess_ratings');

	// get the game info
	$result = $xoopsDB->query("
		SELECT
			g.white_uid AS white_uid, g.black_uid AS black_uid, g.pgn_result AS pgn_result, w.rating AS white_rating, b.rating AS black_rating,
			(w.games_won+w.games_lost+w.games_drawn) AS white_games, (b.games_won+b.games_lost+b.games_drawn) AS black_games
		FROM      $games_table AS g
		LEFT JOIN $ratings_table AS w ON w.player_uid = g.white_uid
		LEFT JOIN $ratings_table AS b ON b.player_uid = g.black_uid
		WHERE     g.game_id = '$gid' AND g.is_rated = '1' AND g.pgn_result != '*'
			AND (w.player_uid IS NULL OR b.player_uid IS NULL OR w.player_uid != b.player_uid)
	");

	// check that game exists and is rated
	if ($xoopsDB->getRowsNum($result) != 1) {
		return false;
	}

	$row = $xoopsDB->fetchArray($result);
	$xoopsDB->freeRecordSet($result);

#var_dump($row);#*#DEBUG#
	// make sure the users are in the players' table
	$value_list = array();
	if (!isset($row['white_rating'])) {
		$row['white_rating'] = $init_rating;
		$row['white_games']  = 0;
		$value_list[] = "('{$row['white_uid']}','{$row['white_rating']}')";
	}
	if (!isset($row['black_rating'])) {
		$row['black_rating'] = $init_rating;
		$row['black_games']  = 0;
		$value_list[] = "('{$row['black_uid']}','{$row['black_rating']}')";
	}
	if (!empty($value_list)) {
		$values = implode(',', $value_list);
		$xoopsDB->query("INSERT INTO $ratings_table (player_uid, rating) VALUES $values");
		$xoopsDB->errno() and trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);
	}

	// calculate new ratings using configured rating system
	list($white_rating_new, $black_rating_new) =
		$func($row['white_rating'], $row['white_games'], $row['black_rating'], $row['black_games'], $row['pgn_result']);

	// determine game-count columns to increment
	list($white_col, $black_col) = chess_ratings_get_columns($row['pgn_result']);

	$xoopsDB->query("
		UPDATE $ratings_table
		SET    rating = '$white_rating_new', $white_col = $white_col + 1
		WHERE  player_uid = '{$row['white_uid']}'
	");
	$xoopsDB->errno() and trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);

	$xoopsDB->query("
		UPDATE $ratings_table
		SET    rating = '$black_rating_new', $black_col = $black_col + 1
		WHERE  player_uid = '{$row['black_uid']}'
	");
	$xoopsDB->errno() and trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);

	return true;
}

/**
 * Recalculate all the players' ratings.
 *
 * @return bool  True if ratings updated, otherwise false
 */
function chess_recalc_ratings()
{
	global $xoopsDB;

	$rating_system = chess_moduleConfig('rating_system');
	$init_rating   = chess_moduleConfig('initial_rating');

	if ($rating_system == 'none') {
		return false;
	}

	// determine function for calculating new ratings using configured rating system
	$func = chess_ratings_get_func_adj($rating_system);

	$games_table   = $xoopsDB->prefix('chess_games');
	$ratings_table = $xoopsDB->prefix('chess_ratings');

	// Nuke the current ratings.  #*#TBD# - don't want to empty this table, since there will be other info in it besides ratings (?)
	$xoopsDB->query("DELETE FROM $ratings_table");

	// get all games
	$result = $xoopsDB->query("
		SELECT    white_uid, black_uid, pgn_result
		FROM      $games_table
		WHERE     is_rated = '1' AND pgn_result != '*' AND white_uid != black_uid
		ORDER BY  last_date ASC
	");

	$players = array();

	// process the games
	while ($row = $xoopsDB->fetchArray($result)) {

#var_dump($row);#*#DEBUG#
		if (!isset($players[$row['white_uid']])) {
			$players[$row['white_uid']] = array('rating' => $init_rating, 'games_won' => 0, 'games_lost' => 0, 'games_drawn' => 0);
		}
		if (!isset($players[$row['black_uid']])) {
			$players[$row['black_uid']] = array('rating' => $init_rating, 'games_won' => 0, 'games_lost' => 0, 'games_drawn' => 0);
		}

		$player_white = &$players[$row['white_uid']];
		$player_black = &$players[$row['black_uid']];
	
		// calculate new ratings using configured rating system
		list($white_rating_new, $black_rating_new) = $func(
			$player_white['rating'],
			$player_white['games_won'] + $player_white['games_lost'] + $player_white['games_drawn'],
			$player_black['rating'],
			$player_black['games_won'] + $player_black['games_lost'] + $player_black['games_drawn'],
			$row['pgn_result']
		);
	
		// determine game-count columns to increment
		list($white_col, $black_col) = chess_ratings_get_columns($row['pgn_result']);
	
		$player_white['rating'] = $white_rating_new;
		++$player_white[$white_col];
	
		$player_black['rating'] = $black_rating_new;
		++$player_black[$black_col];
	}

	$xoopsDB->freeRecordSet($result);

	if (!empty($players)) {
		$value_list = array();
		foreach ($players as $player_uid => $player) {
			$value_list[] = "('$player_uid', '{$player['rating']}', '{$player['games_won']}', '{$player['games_lost']}', '{$player['games_drawn']}')";
		}
		$values = implode(',', $value_list);
	
		$xoopsDB->query("INSERT INTO $ratings_table (player_uid, rating, games_won, games_lost, games_drawn) VALUES $values");
		$xoopsDB->errno() and trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);
	}

	return true;
}

/**
 * Return the number of provisional games.
 *
 * @return int  Number of provisional games for configured rating system, or '0' if no rating system.
 */
function chess_ratings_num_provisional_games()
{
	$rating_system = chess_moduleConfig('rating_system');

	if ($rating_system == 'none') {
		return 0;
	}

	// determine function for getting number of provisional games using configured rating system
	$file = XOOPS_ROOT_PATH . "/modules/chess/include/ratings_{$rating_system}.inc.php";
	file_exists($file) or trigger_error("missing file '$file' for rating system '$rating_system'", E_USER_ERROR);
	require_once $file;
	$func = "chess_ratings_num_provisional_games_{$rating_system}";
	function_exists($func) or trigger_error("missing function '$func' for rating system '$rating_system'", E_USER_ERROR);

	return $func();
}

/**
 * Determine function for calculating new ratings using specified rating system.
 *
 * @param string  $rating_system
 * @return string  Function name
 */
function chess_ratings_get_func_adj($rating_system)
{
	$file = XOOPS_ROOT_PATH . "/modules/chess/include/ratings_{$rating_system}.inc.php";
	file_exists($file) or trigger_error("missing file '$file' for rating system '$rating_system'", E_USER_ERROR);
	require_once $file;
	$func = "chess_ratings_adj_{$rating_system}";
	function_exists($func) or trigger_error("missing function '$func' for rating system '$rating_system'", E_USER_ERROR);
	return $func;
}

/**
 * Determine game-count columns in chess_ratings table to increment.
 *
 * This function was created to avoid having to repeat code that's used in two places.
 *
 * @param string $pgn_result  Game result
 * @return array  Array with two elements:
 *  - $white_col: name of column in white's row to increment
 *  - $black_col: name of column in black's row to increment
 */
function chess_ratings_get_columns($pgn_result)
{
	switch($pgn_result) {
		case '1-0':
			$white_col = 'games_won';
			$black_col = 'games_lost';
			break;
		case '1/2-1/2':
		default: // should not occur
			$white_col = 'games_drawn';
			$black_col = 'games_drawn';
			break;
		case '0-1':
			$white_col = 'games_lost';
			$black_col = 'games_won';
			break;
	}

	return array($white_col, $black_col);
}

?>