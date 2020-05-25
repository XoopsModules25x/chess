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
 * General functions.
 *
 * @param mixed $text
 * @param mixed $allowed_characters
 * @package    chess
 * @subpackage functions
 */

/**
 * Remove unsafe characters from text.
 *
 * @param string $text               Text to be sanitized
 * @param string $allowed_characters Characters permitted in text;
 *                                   must not contain any regex symbols such as \w or \s, since preg_quote() mishandles those.  But \' and \" are ok.
 * @return string  Sanitized text
 */
function chess_sanitize($text, $allowed_characters = 'A-Za-z0-9')
{
    $char_class = preg_replace('/(\.\\\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\#)/', '\\${1}', $allowed_characters);
    //$char_class = preg_quote($allowed_characters, '/');
    return preg_replace("/[^$char_class]/i", '_', $text);
}

/**
 * Get chess module configuration option value.
 *
 * @param string $option Name of configuration option
 * @return string  Value of configuration option
 */
function chess_moduleConfig($option)
{
    global $xoopsModule, $xoopsModuleConfig;

    $value = null;

    if (is_object($xoopsModule) && 'chess' == $xoopsModule->getVar('dirname') && isset($xoopsModuleConfig[$option])) {
        $value = $xoopsModuleConfig[$option];
    } else { // for use within a block
        $moduleHandler = xoops_getHandler('module');

        $module = $moduleHandler->getByDirname('chess');

        $configHandler = xoops_getHandler('config');

        $moduleConfig = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

        if (isset($moduleConfig[$option])) {
            $value = $moduleConfig[$option];
        } else {
            trigger_error("configuration option '$option' not found", E_USER_ERROR);
        }
    }

    return $value;
}

/**
 * Check whether a user has the play-chess right.
 *
 * @param int $uid User ID to check, defaults to current user
 * @return bool  True if user has play-chess right, otherwise false
 */
function chess_can_play($uid = null)
{
    global $xoopsUser;

    if (isset($uid)) {
        $memberHandler = xoops_getHandler('member');

        $user = $memberHandler->getUser($uid);
    } elseif (is_object($xoopsUser)) {
        $user = $xoopsUser;
    } else {
        $user = null;
    }

    $groups_play = chess_moduleConfig('groups_play');

    $can_play = false;

    if (in_array(XOOPS_GROUP_ANONYMOUS, $groups_play)) {
        $can_play = true;
    } elseif (is_object($user)) {
        $can_play = count(array_intersect($user->getGroups(), $groups_play)) > 0;
    }

    return $can_play;
}

/**
 * Check whether a user has the delete-game right.
 *
 * @param int $uid User ID to check, defaults to current user
 * @return bool  True if user has delete-game right, otherwise false
 */
function chess_can_delete($uid = null)
{
    global $xoopsUser;

    if (isset($uid)) {
        $memberHandler = xoops_getHandler('member');

        $user = $memberHandler->getUser($uid);
    } elseif (is_object($xoopsUser)) {
        $user = $xoopsUser;
    } else {
        $user = null;
    }

    $groups_delete = chess_moduleConfig('groups_delete');

    $can_delete = false;

    if (in_array(XOOPS_GROUP_ANONYMOUS, $groups_delete)) {
        $can_delete = true;
    } elseif (is_object($user)) {
        $can_delete = count(array_intersect($user->getGroups(), $groups_delete)) > 0;
    }

    return $can_delete;
}

/**
 * Build string suitable for output as .pgn (Portable Game Notation) file.
 *
 * @param array $data Array with keys:
 *
 *  - 'datetime' - 'YYYY-MM-DD HH:MM:SS'
 *       Use '?' for each unknown digit.  If the entire datetime is unknown, use either '????-??-?? ??:??:??' or '0000-00-00 00:00:00'.
 *  - 'event', 'site', 'round', 'white', 'black', 'result', 'setup', 'fen', 'movetext' - strings (use '?' for entire string if value unknown)
 * @return string
 */
function chess_to_pgn_string($data)
{
    #var_dump('chess_to_pgn_string, data=', $data);#*#DEBUG#

    if ('0000-00-00 00:00:00' == $data['datetime']) {
        $datetime = '????.??.?? ??:??:??';
    } else {
        $datetime = str_replace('-', '.', $data['datetime']);
    }

    [$date, $time] = explode(' ', $datetime);

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

    if ($data['setup'] && $data['fen']) {
        $rtn .= "[Setup \"1\"]\n[FEN \"{$data['fen']}\"]\n";
    }

    $rtn .= "\n$movetext\n";

    return $rtn;
}

/**
 * Get user ID corresponding to the specified username.
 *
 * @param string $uname Username (unsanitized)
 * @return int  User ID, or '0' if user not found
 */
function chess_uname_to_uid($uname)
{
    $criteria = new \CriteriaCompo();

    $criteria->add(new \Criteria('uname', MyTextSanitizer::addSlashes($uname)));

    $criteria->setLimit(1);

    $memberHandler = xoops_getHandler('member');

    $users = $memberHandler->getUserList($criteria);

    $uids = array_keys($users);

    return $uids[0] ?? 0;
}

/*** #*#DEBUG# testing something
 * SELECT
 * g.game_id,g.white_uid AS white_uid, g.black_uid AS black_uid, g.pgn_result AS pgn_result, w.rating AS white_rating, b.rating AS black_rating,
 * (w.games_won+w.games_lost+w.games_drawn) AS white_games, (b.games_won+b.games_lost+b.games_drawn) AS black_games
 * FROM       xoops_chess_games AS g
 * LEFT JOIN xoops_chess_ratings AS w ON w.player_uid = g.white_uid
 * LEFT JOIN xoops_chess_ratings AS b ON b.player_uid = g.black_uid
 * WHERE       g.pgn_result != '*' AND g.is_rated='1' AND (w.player_uid IS NULL OR b.player_uid IS NULL OR w.player_uid != b.player_uid) LIMIT 0, 30
 ***/
