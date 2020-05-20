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
 * Module install/update
 *
 * @package chess
 * @subpackage miscellaneous
 */

/**#@+
 */

// For downward compatibility with XOOPS versions that don't have the function 'xoops_load_lang_file'.
function_exists('xoops_load_lang_file') ? xoops_load_lang_file('modinfo', 'chess') : chess_load_lang_file('modinfo', 'chess');

/**#@-*/

/**
 * Update chess module (pre-processing step).
 *
 * @param  object $module      Module object
 * @param  int    $oldversion  Old version number of module
 * @return bool                True if pre-update succeeded, otherwise false
 */
function xoops_module_pre_update_chess(&$module, $oldversion)
{
	global $xoopsDB;

	// For downward-compatiblity, in case this function doesn't get called by the module handler.
	$GLOBALS['chess_module_pre_update_called'] = true;

	if ($oldversion < 102) { // old version < 1.02: direct update not supported.

		$docfile = XOOPS_ROOT_PATH . '/modules/chess/docs/INSTALL.TXT';
		chess_set_message($module, sprintf(_MI_CHESS_OLD_VERSION, strval($oldversion), $docfile), true);
		return false;

	} elseif ($oldversion >= 107) { // old version >= 1.07:  no action needed.

		return true;
	}

	// 1.02 <= old version < 1.07: perform update.

	$ratings_table    = $xoopsDB->prefix('chess_ratings');
	$challenges_table = $xoopsDB->prefix('chess_challenges');
	$games_table      = $xoopsDB->prefix('chess_games');

	// Check that ratings table does not already exist.
	chess_set_message($module, sprintf(_MI_CHESS_RATINGS_TABLE_1, $ratings_table));
	$result = $xoopsDB->query("SHOW TABLES LIKE '$ratings_table'");
	if (!$result) {
		$mysql_errno = $xoopsDB->errno();
		$mysql_error = $xoopsDB->error();
		chess_set_message($module, sprintf(_MI_CHESS_RATINGS_TABLE_2, $ratings_table, strval($mysql_errno), $mysql_error), true);
		return false;
	}
	if ($xoopsDB->getRowsNum($result) > 0) {
		chess_set_message($module, sprintf(_MI_CHESS_RATINGS_TABLE_3, $ratings_table), true);
		return false;
	}
	$xoopsDB->freeRecordSet($result);
	chess_set_message($module, _MI_CHESS_OK);

	// Check database tables.
	chess_set_message($module, _MI_CHESS_CHK_DB_TABLES);
	$table_check_messages = chess_check_tables(array($challenges_table, $games_table));
	if (!empty($table_check_messages)) {
		foreach ($table_check_messages as $message) {
			chess_set_message($module, $message, true);
		}
		return false;
	}
	chess_set_message($module, _MI_CHESS_OK);

	// Check that values in column pgn_result of games table are in range.
	$pgn_result_values = "'*','1-0','0-1','1/2-1/2'";
	chess_set_message($module, sprintf(_MI_CHESS_GAMES_TABLE_1, $games_table));
	$result = $xoopsDB->query("SELECT COUNT(*) FROM `$games_table` WHERE `pgn_result` NOT IN ($pgn_result_values)");
	if (!$result) {
		$mysql_errno = $xoopsDB->errno();
		$mysql_error = $xoopsDB->error();
		chess_set_message($module, sprintf(_MI_CHESS_GAMES_TABLE_2, $games_table, strval($mysql_errno), $mysql_error), true);
		return false;
	}
	list($count) = $xoopsDB->fetchRow($result);
	if ($count > 0) {
		chess_set_message($module, sprintf(_MI_CHESS_GAMES_TABLE_3, 'pgn_result', $games_table, $pgn_result_values), true);
		chess_set_message($module, _MI_CHESS_GAMES_TABLE_4, true);
		return false;
	}
	$xoopsDB->freeRecordSet($result);
	chess_set_message($module, _MI_CHESS_OK);

	return true; // successful
}

/**
 * Update chess module (post-processing step).
 *
 * @param  object $module      Module object
 * @param  int    $oldversion  Old version number of module
 * @return bool                True if update succeeded, otherwise false
 */
function xoops_module_update_chess(&$module, $oldversion)
{
	global $xoopsDB;

	// Before proceeding, ensure that pre-update processing has been done, and that all the checks pass.
	// For downward-compatiblity, in case the "pre_update" function doesn't get called by the module handler.
	if (!@$GLOBALS['chess_module_pre_update_called'] and !xoops_module_pre_update_chess($module, $oldversion)) {
		return false;
	}

	if ($oldversion >= 107) { // old version >= 1.07:  no action needed.
		return true;
	}

	$ratings_table    = $xoopsDB->prefix('chess_ratings');
	$challenges_table = $xoopsDB->prefix('chess_challenges');
	$games_table      = $xoopsDB->prefix('chess_games');

	$queries = array(

		"CREATE TABLE `$ratings_table` (
			`player_uid` mediumint(8) unsigned NOT NULL default '0',
			`rating` smallint(6) unsigned NOT NULL default '1200',
			`games_won` smallint(6) unsigned NOT NULL default '0',
			`games_lost` smallint(6) unsigned NOT NULL default '0',
			`games_drawn` smallint(6) unsigned NOT NULL default '0',
			PRIMARY KEY (`player_uid`),
			KEY `rating` (`rating`),
			KEY `games` (`games_won`,`games_lost`,`games_drawn`)
			) TYPE=MyISAM",

		"ALTER TABLE `$challenges_table` ADD `is_rated` ENUM('1','0') DEFAULT '1' NOT NULL",
		"ALTER TABLE `$challenges_table` ADD INDEX `game_type` (`game_type`)",
		"ALTER TABLE `$challenges_table` ADD INDEX `player1_uid` (`player1_uid`)",
		"ALTER TABLE `$challenges_table` ADD INDEX `player2_uid` (`player2_uid`)",
		"ALTER TABLE `$challenges_table` ADD INDEX `create_date` (`create_date`)",
		"ALTER TABLE `$challenges_table` ADD INDEX `is_rated` (`is_rated`)",

		"ALTER TABLE `$games_table` CHANGE `pgn_result` `pgn_result` ENUM('*','0-1','1-0','1/2-1/2') DEFAULT '*' NOT NULL",
		"ALTER TABLE `$games_table` ADD `is_rated` ENUM('1','0') DEFAULT '1' NOT NULL",
		"ALTER TABLE `$games_table` ADD INDEX `white_uid` (`white_uid`)",
		"ALTER TABLE `$games_table` ADD INDEX `black_uid` (`black_uid`)",
		"ALTER TABLE `$games_table` ADD INDEX `date` (`create_date`,`start_date`,`last_date`)",
		"ALTER TABLE `$games_table` ADD INDEX `pgn_result` (`pgn_result`)",
		"ALTER TABLE `$games_table` ADD INDEX `suspended_date` (`suspended`(19))",
		"ALTER TABLE `$games_table` ADD INDEX `is_rated` (`is_rated`)",

		"UPDATE `$games_table` SET `is_rated` = '0' WHERE `white_uid` = `black_uid`",
	);

	// Update database tables.
	chess_set_message($module, _MI_CHESS_UPDATING_DATABASE);
	foreach ($queries as $query) {
		chess_set_message($module, "> $query");
		$result = $xoopsDB->query($query);
		if (!$result) {
			$mysql_errno = $xoopsDB->errno();
			$mysql_error = $xoopsDB->error();
			chess_set_message($module, " ... ($mysql_errno) $mysql_error");
			return false;
		}
		chess_set_message($module, _MI_CHESS_OK);
	}

/***
	#*#TODO# - Leave this here for now, in case I think of a way to get it to work.
	# This causes an error about the rating_system module configuration parameter not being defined,
	# so I added a note in INSTALL.TXT about manually recalculating the ratings after install.

	// Initialize ratings table.
	chess_set_message($module, _MI_CHESS_INIT_RATINGS_TABLE);
	require_once XOOPS_ROOT_PATH . '/modules/chess/include/ratings.inc.php';
	chess_recalc_ratings();
***/

	chess_set_message($module, _MI_CHESS_UPDATE_SUCCESSFUL);

	return true; // successful
}

/**
 * Check the specified tables in the currently selected database.
 *
 * @param  array  $table_names  Names of database tables to check.
 * @return array                Diagnostic messages, or empty array if no errors.
 */
function chess_check_tables($table_names)
{
	global $xoopsDB;

	$messages = array();

	foreach ($table_names as $table_name) {

		$query = "CHECK TABLE `$table_name`";
		$result = $xoopsDB->query($query);
		if (!$result) {
			$mysql_errno = $xoopsDB->errno();
			$mysql_error = $xoopsDB->error();
			$messages[] = $query;
			$messages[] = " ... ($mysql_errno) $mysql_error";
			continue;
		}

		// Initialize, in case the real table status fails to get retrieved.
		$table_status = '*** STATUS UNKNOWN ***';

		// The query may return multiple rows.  Only the last row is normally of interest, so only that row is saved.
		while ($row = $xoopsDB->fetchArray($result)) {
			$table_status = $row['Msg_text'];
		}

		$xoopsDB->freeRecordSet($result);

		if ($table_status != 'OK') {
			$messages[] = " ... $table_name: $table_status";
		}
	}

	return $messages;
}

/**
 * Load the specified localized strings file
 *
 * For downward compatibility with XOOPS versions that don't have the function 'xoops_load_lang_file'.
 *
 * @param string $filename  Name of language file to include, without the file extension.
 * @param string $module    Module directory name.
 * @param string $default   Default language subdirectory, used if file for configured language isn't found.
 * @return mixed            Return value from including the file.
 */
function chess_load_lang_file( $filename, $module = '', $default = 'english' )
{
	$lang = $GLOBALS['xoopsConfig']['language'];
	$path = XOOPS_ROOT_PATH . ( empty($module) ? '/' : "/modules/$module/" ) . 'language';
	if ( !( $ret = @include_once( "$path/$lang/$filename.php" ) ) ) {
		$ret = include_once( "$path/$default/$filename.php" );
	}
	return $ret;
}

/**
 * Output a message during module install/upgrade
 *
 * @param object $module  Module object
 * @param string $text    Text to display
 * @param bool   $error   True if text is an error message that should be displayed with emphasis, false otherwise.
 */
function chess_set_message(&$module, $text = '', $error = false)
{
	$text = $error ? "<span style='color:#ff0000;background-color:#ffffff;font-weight:bold;'>$text</span>" : $text;

	// For downward compatibility with XOOPS versions that don't have the method XoopsModule::setMessage.
	if (is_object($module) and method_exists($module, 'setMessage')) {
		$module->setMessage($text);
	} else {
		echo "<code>$text</code><br />\n";
	}
}

?>