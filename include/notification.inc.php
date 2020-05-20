<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
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
 * Required file for supporting notification feature
 *
 * @package chess
 * @subpackage notification
 */

/**#@+
 */
// Needed since module language constants are used here.
// The language file gets automatically included within this module,
// but not when viewing the notifications page via notifications.php.
global $xoopsConfig;
if (file_exists(XOOPS_ROOT_PATH . "/modules/chess/language/{$xoopsConfig['language']}/main.php")) {
    require_once XOOPS_ROOT_PATH . "/modules/chess/language/{$xoopsConfig['language']}/main.php";
} else {
    require_once XOOPS_ROOT_PATH . '/modules/chess/language/english/main.php';
}
/**#@-*/

/**
 * Get name and URL of notification item.
 *
 * @param string $category  Notification category
 * @param int    $item_id   ID of item for which notification is being made
 * @return array  Array containing two elements:
 *  - Name of item
 *  - URL of item
 */
function chess_notify_item_info($category, $item_id)
{
    if ($category == 'global') {
        $item['name'] = 'Chess';
        $item['url']  = XOOPS_URL . '/modules/chess/';
        return $item;
    } elseif ($category == 'game') {
        global $xoopsDB;

        $table  = $xoopsDB->prefix('chess_games');
        $result = $xoopsDB->query(trim("
			SELECT white_uid, black_uid, UNIX_TIMESTAMP(start_date) AS start_date
			FROM   $table
			WHERE  game_id = '$item_id'
		"));
        $gamedata = $xoopsDB->fetchArray($result);
        $xoopsDB->freeRecordSet($result);

        if ($gamedata !== false) {

            // get mapping of user IDs to usernames
            $criteria       =  new Criteria('uid', "({$gamedata['white_uid']}, {$gamedata['black_uid']})", 'IN');
            $memberHandler = xoops_getHandler('member');
            $usernames      =  $memberHandler->getUserList($criteria);

            $username_white =  isset($usernames[$gamedata['white_uid']]) ? $usernames[$gamedata['white_uid']] : _MD_CHESS_NA;
            $username_black =  isset($usernames[$gamedata['black_uid']]) ? $usernames[$gamedata['black_uid']] : _MD_CHESS_NA;

            $date = $gamedata['start_date'] ? date('Y.m.d', $gamedata['start_date']) : _MD_CHESS_NA;
        } else {
            $username_white = _MD_CHESS_NA;
            $username_black = _MD_CHESS_NA;
            $date           = _MD_CHESS_NA;
        }

        $item['name'] = "$username_white " ._MD_CHESS_LABEL_VS. " $username_black ($date)";
        $item['url']  = XOOPS_URL . '/modules/chess/game.php?game_id=' . $item_id;
        return $item;
    }
}
