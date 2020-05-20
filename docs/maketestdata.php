 <?php

/**
 * Generate test data in MySQL database tables for chess module.
 *
 * This script is designed to be run from the command line, not from a web browser.
 *
 * @package chess
 * @subpackage test
 */

error_reporting(E_ALL);

/**#@+
 */
define('DBHOST', 'localhost');
define('DBNAME', 'test');
define('DBUSER', 'root');
define('DBPASS', '');

define('NUM_USERS',      3);
define('NUM_CHALLENGES', 1000);
define('NUM_GAMES',      10000);
define('NUM_RATINGS',    NUM_USERS / 2);
/**#@-*/

perform();

/**
 * Generate the test data.
 */
function perform() {

	$challenges_table = 'chess_challenges';
	$games_table      = 'chess_games';
	$ratings_table    = 'chess_ratings';

	@mysql_connect(DBHOST, DBUSER, DBPASS) or trigger_error('[' .mysql_errno(). '] ' .mysql_error(), E_USER_ERROR);
	mysql_select_db(DBNAME)                or trigger_error('[' .mysql_errno(). '] ' .mysql_error(), E_USER_ERROR);

// For safety, don't generate test data unless the tables are empty.

	if (!table_empty($challenges_table) or !table_empty($games_table) or !table_empty($ratings_table)) {
		echo "Tables already contain data - no action performed.\n";
		exit;
	}

// Generate the challenges table

	$game_types    = array('open', 'user');
	$color_options = array('player2', 'random', 'white', 'black');

	for ($i = 0; $i < NUM_CHALLENGES; ++$i) {

		$game_type = rand_array_value($game_types);

		$fen_index = rand(1, 10);
		$fen = ($fen_index == 10) ? 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1' : '';

		$color_option = rand_array_value($color_options);

		$notify_move_player1 = rand(0, 1);

		$player1_uid = rand(1, NUM_USERS);
		if ($game_type == 'open') {
			$player2_uid = 0;
		} else {
			// select $player2_uid != $player1_uid
			do {
				$player2_uid = rand(1, NUM_USERS);
			} while ($player2_uid == $player1_uid);
		}
	
		$create_date_max = time();
		$create_date_min = $create_date_max - 30 * 24 * 3600;
		$create_date = date('Y-m-d H:i:s', rand($create_date_min, $create_date_max));
	
		$is_rated = rand(0, 1);
	
		do_query("
			INSERT INTO $challenges_table
			SET
				game_type           = '$game_type',
				fen                 = '$fen',
				color_option        = '$color_option',
				notify_move_player1 = '$notify_move_player1',
				player1_uid         = '$player1_uid',
				player2_uid         = '$player2_uid',
				create_date         = '$create_date',
				is_rated            = '$is_rated'
		");
	}

// Generate the games table

	$pgn_results        = array('*', '0-1', '1-0', '1/2-1/2');
	$suspended_explains = array('foo', 'bar', 'baz', 'quux');

	for ($i = 0; $i < NUM_GAMES; ++$i) {

		$white_uid = rand(1, NUM_USERS);
		$black_uid = rand(1, NUM_USERS);
		// Force some games to be self-play.
		if (rand(1, 10) == 10) {
			$black_uid = $white_uid;
		}

		$create_date_max = time();
		$create_date_min = $create_date_max - 365 * 24 * 3600;
		$create_date_sec = rand($create_date_min, $create_date_max);
		$create_date = date('Y-m-d H:i:s', $create_date_sec);

		$is_started = rand(1, 4) < 4;
		$start_date_sec = $is_started ? $create_date_sec + rand(3600, 3 * 24 * 3600) : 0;
		$start_date     = $is_started ? date('Y-m-d H:i:s', $start_date_sec) : '0000-00-00 00:00:00';
	
		$multiple_moves = $is_started && rand(1, 10) < 10;
		$last_date_sec = $multiple_moves ? $start_date_sec + rand(3600, 90 * 24 * 3600) : 0;
		$last_date     = $multiple_moves ? date('Y-m-d H:i:s', $last_date_sec) : '0000-00-00 00:00:00';

		$pgn_result = $multiple_moves ? rand_array_value($pgn_results) : '*';

		if ($multiple_moves and $pgn_result == '*' and rand(1, 5) == 5) {
			$suspended_date    = date('Y-m-d H:i:s', $last_date_sec + rand(60, 72 * 3600));
			$suspended_uids    = array(1, $white_uid, $black_uid);
			$suspended_uid     = rand_array_value($suspended_uids);
			$suspended_type    = $suspended_uid == 1 ? 'arbiter_suspend' : 'want_arbitration';
			$suspended_explain = rand_array_value($suspended_explains);
			$suspended         = "$suspended_date|$suspended_uid|$suspended_type|$suspended_explain";
		} else {
			$suspended         = '';
		}
	
		$is_rated = $white_uid != $black_uid ? rand(0, 1) : 0;
	
		do_query("
			INSERT INTO $games_table
			SET
				white_uid   = '$white_uid',
				black_uid   = '$black_uid',
				create_date = '$create_date',
				start_date  = '$start_date',
				last_date   = '$last_date',
				pgn_result  = '$pgn_result',
				suspended   = '$suspended',
				is_rated    = '$is_rated'
		");
	}

	mysql_close();
}

/**
 * Check whether table is empty.
 *
 * @param string $table Table name
 * @return bool True if table is empty
 */
function table_empty($table) {

	$result = do_query("SELECT COUNT(*) FROM $table");
	list($num_rows) = mysql_fetch_row($result);
	mysql_free_result($result);
	return $num_rows == 0;
}

/**
 * Perform MySQL query.
 *
 * If the result from mysql_query() is false, trigger_error() is called to display the error.
 *
 * @param string $query The query to perform
 * @return resource Return from mysql_query()
 */
function do_query($query) {

	$result = mysql_query($query);
	if ($result === false) {
		$errno = mysql_errno();
		$error = mysql_error();
		trigger_error("[$errno] $error\n$query", E_USER_ERROR);
	}
	return $result;
}

function rand_array_value(&$array) {
	return $array[array_rand($array)];
}

?>