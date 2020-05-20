<?php
// $Id: notification.inc.php,v 1.1 2004/01/29 15:28:30 buennagel Exp $
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

function chess_notify_item_info($category, $item_id)
{
	$module_handler = xoops_getHandler('module');
	$module         = $module_handler->getByDirname('chess');

	if ($category == 'global') {
		$item['name'] = 'Chess';
		$item['url']  = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/';
		return $item;

	} elseif ($category == 'game') {

		global $xoopsDB;

		$table    = $xoopsDB->prefix('chess_games');
		$result = $xoopsDB->query(trim("
			SELECT white_uid, black_uid, UNIX_TIMESTAMP(start_date) AS start_date
			FROM   $table
			WHERE  game_id = '$item_id'
		"));
		$gamedata = $xoopsDB->fetchArray($result);
		$xoopsDB->freeRecordSet($result);

	 	if ($gamedata !== FALSE) {

			$member_handler = xoops_getHandler('member');

			$user_white     = $member_handler->getUser($gamedata['white_uid']);
			$username_white =  is_object($user_white) ? $user_white->getVar('uname') : '(open)';

			$user_black     = $member_handler->getUser($gamedata['black_uid']);
			$username_black =  is_object($user_black) ? $user_black->getVar('uname') : '(open)';

			$date = $gamedata['start_date'] ? date('Y.m.d', $gamedata['start_date']) : 'not yet started';

		} else {

			$username_white = '(open)';
			$username_black = '(open)';
			$date           = 'not yet started';
		}

		$item['name'] = "$username_white vs. $username_black ($date)";
		$item['url']  = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/game.php?game_id=' . $item_id;
		return $item;
	}
}

?>
