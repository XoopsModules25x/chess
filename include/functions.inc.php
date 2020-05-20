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

// ----------------------------------------------------------------
// Remove unsafe characters from text.
//
// $allowed_characters must not contain any regex symbols such as \w or \s,
// since preg_quote() mishandles those.  But \' and \" are ok.

function chess_sanitize($text, $allowed_characters = 'A-Za-z0-9') {

	$char_class = preg_quote($allowed_characters, '/');
	return preg_replace("/[^$char_class]/", '_', $text);
}

// --------------------------------------
// Get module configuration option value.

function chess_moduleConfig($option)
{
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname('chess');
	$config_handler =& xoops_gethandler('config');
	$moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	return $moduleConfig[$option];
}

// -----------------------------------------------------------
// Return true if user has play-right, otherwise return false.
//
// $uid - user number of user to check, defaults to current user

function chess_can_play($uid = null)
{
	global $xoopsUser;

	if (isset($uid)) {
		$member_handler =& xoops_gethandler('member');
		$user =& $member_handler->getUser($uid);
	} elseif (is_object($xoopsUser)) {
		$user =& $xoopsUser;
	} else {
		$user = null;
	}
		
	$groups_play = chess_moduleConfig('groups_play');

	$can_play = false;

	if (in_array(XOOPS_GROUP_ANONYMOUS, $groups_play)) {
		$can_play = true;
	} elseif (is_object($user)) {
		$groups =& $user->getGroups();
		foreach ($groups as $group) {
			if (in_array($group['groupid'], $groups_play)) {
				$can_play = true;
				break;
			}
		}
	}

	return $can_play;
}

// ---------------------------------------------------------------------
// Return true if user has delete-right, otherwise return false.
//
// $uid - user number of user to check, defaults to current user

function chess_can_delete($uid = null)
{
	global $xoopsUser;

	if (isset($uid)) {
		$member_handler =& xoops_gethandler('member');
		$user =& $member_handler->getUser($uid);
	} elseif (is_object($xoopsUser)) {
		$user =& $xoopsUser;
	} else {
		$user = null;
	}
		
	$groups_delete = chess_moduleConfig('groups_delete');

	$can_delete = false;

	if (in_array(XOOPS_GROUP_ANONYMOUS, $groups_delete)) {
		$can_delete = true;
	} elseif (is_object($user)) {
		$groups =& $user->getGroups();
		foreach ($groups as $group) {
			if (in_array($group['groupid'], $groups_delete)) {
				$can_delete = true;
				break;
			}
		}
	}

	return $can_delete;
}

// ------------------------------------------------------------------------
// Return string suitable for output as .pgn (Portable Game Notation) file.
//
// data - array with keys:
//
//    'datetime' - 'YYYY-MM-DD HH:MM:SS'
//       Use '?' for each unknown digit.  If the entire datetime is unknown, use either '????-??-?? ??:??:??' or '0000-00-00 00:00:00'.
//    'event', 'site', 'round', 'white', 'black', 'result', 'setup', 'fen', 'movetext' - strings (use '?' for entire string if value unknown)

function chess_to_pgn_string($data)
{
#var_dump('chess_to_pgn_string, data=', $data);#*#DEBUG#
	if ($data['datetime'] == '0000-00-00 00:00:00') {
		$datetime = '????.??.?? ??:??:??';
	} else {
		$datetime = str_replace('-', '.', $data['datetime']);
	}
	list($date, $time) = explode(' ', $datetime);

	$movetext = wordwrap($data['movetext'], 75);

	$rtn = <<<END
[Event "{$data['event']}"]
[Site "{$data['site']}"]
[Date "$date"]
[Time "$time"]
[Round "{$data['round']}"]
[White "{$data['white']}"]
[Black "{$data['black']}"]
[Result "{$data['result']}"]

END;

	if ($data['setup'] and $data['fen']) {
		$rtn .= "[Setup \"1\"]\n[FEN \"{$data['fen']}\"]\n";
	}

	$rtn .= "\n$movetext\n";

	return $rtn;
}

?>
