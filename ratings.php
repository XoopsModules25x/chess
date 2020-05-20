<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
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
 * Display player ratings.
 *
 * @package chess
 * @subpackage ratings
 */

/**#@+
 */
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/constants.inc.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/functions.inc.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/ratings.inc.php';

// check whether the rating feature is enabled
if ('none' == chess_moduleConfig('rating_system')) {
    redirect_header(XOOPS_URL . '/modules/chess/index.php', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_RATINGS_OFF);
}

$GLOBALS['xoopsOption']['template_main'] = 'chess_ratings.tpl';
$xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0; // disable caching
require_once XOOPS_ROOT_PATH . '/header.php';

// user input
$submit_recalc_ratings  = isset($_POST['submit_recalc_ratings']);
$confirm_recalc_ratings = intval(@$_POST['confirm_recalc_ratings']);
$start                  = intval(@$_GET['start']); // for page nav: offset of first row of results to display (default to 0)

#var_dump($_REQUEST);#*#DEBUG#

// If form-submit, check security token.
if ($submit_recalc_ratings && is_object($GLOBALS['xoopsSecurity']) && !$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(
        XOOPS_URL . '/modules/chess/ratings.php',
        _CHESS_REDIRECT_DELAY_FAILURE,
        _MD_CHESS_TOKEN_ERROR . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors())
    );
}

$msg       = '';
$msg_class = '';

// If arbiter requested recalculation of ratings, do it.
if ($submit_recalc_ratings && is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
    if ($confirm_recalc_ratings) {
        chess_recalc_ratings();
        $msg       = _MD_CHESS_RECALC_DONE;
        $msg_class = 'resultMsg';
    } else {
        $msg       = _MD_CHESS_RECALC_NOT_DONE;
        $msg_class = 'errorMsg';
    }
}

// Display the ratings.
chess_ratings($start, $msg, $msg_class);

require_once XOOPS_ROOT_PATH . '/footer.php';
/**#@-*/

/**
 * Display all the players' ratings.
 *
 * @param int    $start      Starting offset for page navigator
 * @param string $msg        Message to display (if non-empty string)
 * @param string $msg_class  CSS class for displaying message text
 */
function chess_ratings($start = 0, $msg = '', $msg_class = 'errorMsg')
{
    global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsTpl;

    // Display ratings.

    // Get maximum number of items to display on a page, and constrain it to a reasonable value.
    $max_items_to_display = chess_moduleConfig('max_items');
    $max_items_to_display = min(max($max_items_to_display, 1), 1000);

    $games_table   = $xoopsDB->prefix('chess_games');
    $ratings_table = $xoopsDB->prefix('chess_ratings');
    
    // Two queries are performed, one without a limit clause to count the total number of rows for the page navigator,
    // and one with a limit clause to get the data for display on the current page.
    // SQL_CALC_FOUND_ROWS and FOUND_ROWS(), available in MySQL 4.0.0, provide a more efficient way of doing this.

    $result = $xoopsDB->query("
		SELECT    COUNT(*)
		FROM      $ratings_table AS p
	");
    [$num_items] = $xoopsDB->fetchRow($result);
    $xoopsDB->freeRecordSet($result);

    $pagenav = new XoopsPageNav($num_items, $max_items_to_display, $start, 'start');

    $result = $xoopsDB->query("
		SELECT    player_uid, rating, (games_won+games_lost+games_drawn) AS games_played
		FROM      $ratings_table
		ORDER BY  rating DESC, player_uid ASC
		LIMIT     $start, $max_items_to_display
	");

    // user IDs that will require mapping to usernames
    $userids = [];

    $players = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {

        // save user IDs that will require mapping to usernames
        $userids[] = $row['player_uid'];

        $players[] = [
            'player_uid'   => $row['player_uid'],
            'rating'       => $row['rating'],
            'games_played' => $row['games_played'],
        ];
    }
    $xoopsDB->freeRecordSet($result);

    // get mapping of user IDs to usernames
    $memberHandler = xoops_getHandler('member');
    $criteria       =  new Criteria('uid', '(' . implode(',', $userids) . ')', 'IN');
    $usernames      =  $memberHandler->getUserList($criteria);

    // add usernames to $players
    foreach ($players as $k => $player) {
        $players[$k]['player_uname'] = isset($usernames[$player['player_uid']]) ? $usernames[$player['player_uid']] : '?';
    }

    // Display form for arbiter to recalculate ratings.

    if (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {

        // security token added below
        $form = new XoopsThemeForm(_MD_CHESS_RECALC_RATINGS, 'form1', 'ratings.php');

        // checkbox (initially unchecked)
        $checked_value = 1;
        $checkbox_confirm_recalc_ratings = new XoopsFormCheckBox('', 'confirm_recalc_ratings', !$checked_value);
        $checkbox_confirm_recalc_ratings->addOption($checked_value, _MD_CHESS_RECALC_CONFIRM);
        $form->addElement($checkbox_confirm_recalc_ratings);

        $form->addElement(new XoopsFormButton('', 'submit_recalc_ratings', _MD_CHESS_SUBMIT_BUTTON, 'submit'));

        $form->assign($xoopsTpl);

        // security token
        // This method is used because form is templated.
        $xoopsTpl->assign('chess_xoops_request_token', is_object($GLOBALS['xoopsSecurity']) ? $GLOBALS['xoopsSecurity']->getTokenHTML() : '');
    }

    // Template variables

    $xoopsTpl->assign('chess_provisional_games', chess_ratings_num_provisional_games());
    $xoopsTpl->assign('chess_msg', $msg);
    $xoopsTpl->assign('chess_msg_class', $msg_class);
    $xoopsTpl->assign('chess_players_pagenav', $pagenav->renderNav());
    $xoopsTpl->assign('chess_players', $players);
}
