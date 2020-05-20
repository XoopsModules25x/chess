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
 * Handle an individual chess game.
 *
 * The array $gamedata used throughout this file contains the columns of the
 * database row for the current game.
 * @see ChessGame
 *
 * @package chess
 * @subpackage game
 */

/**#@+
 */
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

$GLOBALS['xoopsOption']['template_main'] = 'chess_game_main.tpl';
$xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0; // disable caching
require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/class/chessgame.inc.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/constants.inc.php';
require_once XOOPS_ROOT_PATH . '/modules/chess/include/functions.inc.php';

chess_game();

require_once XOOPS_ROOT_PATH . '/include/comment_view.php';
require_once XOOPS_ROOT_PATH . '/footer.php';
/**#@-*/

/**
 * Handle an individual chess game.
 *
 * processing:
 *  - fetch game data from database
 *  - handle user request
 *  - update game data in database
 *  - display board
 */
function chess_game()
{
    // user input
    $game_id           = intval(@$_GET['game_id']);
    $submit_move       = isset($_POST['submit_move']);
    $submit_refresh    = isset($_POST['submit_refresh']);
    $move              = chess_sanitize(trim(@$_POST['chessmove']), 'A-Za-z0-9=-');
    $movetype          = chess_sanitize(@$_POST['movetype']);
    $confirm           = isset($_POST['confirm']) ? 1 : 0;
    $move_explain      = chess_sanitize(trim(@$_POST['move_explain']), 'A-Za-z0-9 .,;:=()[]*?!-');
    $arbiter_explain   = chess_sanitize(trim(@$_POST['arbiter_explain']), 'A-Za-z0-9 .,;:=()[]*?!-');
    $orientation       = chess_sanitize(@$_POST['orientation']);
    $show_arbiter_ctrl = isset($_POST['show_arbiter_ctrl']);
    $submit_arbitrate  = isset($_POST['submit_arbitrate']);
    $arbiter_action    = chess_sanitize(@$_POST['arbiter_action']);

    // If form-submit, check security token.
    if (($submit_move || $submit_refresh || $submit_arbitrate || $show_arbiter_ctrl) && is_object($GLOBALS['xoopsSecurity']) && !$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(
            XOOPS_URL . '/modules/chess/',
            _CHESS_REDIRECT_DELAY_FAILURE,
            _MD_CHESS_TOKEN_ERROR . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors())
        );
    }

    // Fetch the game data from the database.
    $gamedata = chess_get_game($game_id);
    if ($gamedata === false) {
        redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_FAILURE, _MD_CHESS_GAME_NOT_FOUND);
    }

    $gamedata_updated      = false;
    $move_performed        = false; // status result from move-handler
    $move_result_text      = '';    // text result from move-handler
    $draw_claim_error_text = '';    // text describing invalid draw-claim
    $notify                = '';    // text description of action for notification
    $delete_game           = false;

    global $xoopsUser;
    $uid =  $xoopsUser ? $xoopsUser->getVar('uid') : 0;

    $selfplay = $gamedata['white_uid'] == $gamedata['black_uid'];

    if ($selfplay) {
        if ($uid == $gamedata['white_uid']) {
            $user_color = $gamedata['fen_active_color']; // current user is either player, so consider him active player
        } else {
            $user_color = '';                            // current user is not a player
        }

        // not self-play
    } else {
        if ($uid == $gamedata['white_uid']) {
            $user_color = 'w'; // current user is white
        } elseif ($uid == $gamedata['black_uid']) {
            $user_color = 'b'; // current user is black
        } else {
            $user_color = '';  // current user is not a player
        }
    }

    // Determine whether current user is a player in the current game, and whether it's his move.
    $user_is_player         = $user_color == 'w' || $user_color == 'b';
    $user_is_player_to_move = $user_color == $gamedata['fen_active_color'];

    $user_color_name = $user_color == 'w' ? _MD_CHESS_WHITE : _MD_CHESS_BLACK;

    if ($submit_move && !$gamedata['suspended']) {

        // If the player has changed his confirm-move preference, it needs to be updated in the database.
        // For a self-play game, the white and black confirm-move preferences are kept the same, to avoid confusion.
        if ($user_is_player) {
            if ($user_color == 'w' && $gamedata['white_confirm'] != $confirm) {
                $gamedata['white_confirm'] = $confirm;
                if ($selfplay) {
                    $gamedata['black_confirm'] = $confirm;
                }
                $gamedata_updated = true;
            } elseif ($user_color == 'b' && $gamedata['black_confirm'] != $confirm) {
                $gamedata['black_confirm'] = $confirm;
                if ($selfplay) {
                    $gamedata['white_confirm'] = $confirm;
                }
                $gamedata_updated = true;
            }
        }

        switch ($movetype) {

            default:
            case _CHESS_MOVETYPE_NORMAL:
                if ($user_is_player_to_move && $gamedata['offer_draw'] != $user_color) {
                    [$move_performed, $move_result_text] = chess_move($gamedata, $move);
                    if ($move_performed) {
                        if ($selfplay) { // If self-play, the current user's color switches.
                            $user_color = $gamedata['fen_active_color'];
                        }
                        $gamedata['offer_draw'] = '';
                        $gamedata_updated       = true;
                        $notify                 = "$user_color_name: $move";
                    }
                }
                break;

            case _CHESS_MOVETYPE_CLAIM_DRAW_3:
            case _CHESS_MOVETYPE_CLAIM_DRAW_50:
                if ($user_is_player_to_move && $gamedata['offer_draw'] != $user_color) {
                    if (!empty($move)) {
                        [$move_performed, $move_result_text] = chess_move($gamedata, $move);
                        #var_dump('chess_game', $move_performed, $move_result_text);#*#DEBUG#
                        if ($move_performed) {
                            if ($selfplay) { // If self-play, the current user's color switches.
                                $user_color = $gamedata['fen_active_color'];
                            }
                            $gamedata['offer_draw'] = '';
                            $gamedata_updated       = true;
                            $notify                 = "$user_color_name: $move";
                        } else {
                            break; // move invalid, so don't bother checking draw-claim
                        }
                    }
                    [$draw_claim_valid, $draw_claim_text] = $movetype == _CHESS_MOVETYPE_CLAIM_DRAW_3
                        ? chess_is_draw_threefold_repetition($gamedata) : chess_is_draw_50_move_rule($gamedata);
                    #var_dump('chess_game', $draw_claim_valid, $draw_claim_text);#*#DEBUG#
                    if ($draw_claim_valid) {
                        $gamedata['offer_draw']   = '';
                        $gamedata['pgn_result']   = '1/2-1/2';
                        $comment                  = '{' . $draw_claim_text . '}';
                        $gamedata['pgn_movetext'] = str_replace('*', "{$gamedata['pgn_result']} $comment", $gamedata['pgn_movetext']);
                        $gamedata_updated         = true;
                        $notify                   = !empty($move) ? "$user_color_name: $move: $draw_claim_text" : "$user_color_name: $draw_claim_text";
                    } else {
                        $draw_claim_error_text    = $draw_claim_text;
                    }
                }
                break;

            case _CHESS_MOVETYPE_RESIGN:
                if ($user_is_player) {
                    $gamedata['offer_draw']   = '';
                    $gamedata['pgn_result']   = $user_color == 'w' ? '0-1' : '1-0';
                    $comment                  = '{' . $user_color_name . ' ' . _MD_CHESS_RESIGNED . '}';
                    $gamedata['pgn_movetext'] = str_replace('*', "{$gamedata['pgn_result']} $comment", $gamedata['pgn_movetext']);
                    $gamedata_updated         = true;
                    $notify                   = "$user_color_name " . _MD_CHESS_RESIGNED;
                }
                break;

            case _CHESS_MOVETYPE_OFFER_DRAW:
                if ($user_is_player && empty($gamedata['offer_draw']) && !$selfplay) {
                    $gamedata['offer_draw'] = $user_color;
                    $gamedata_updated       = true;
                    $notify                 = "$user_color_name " . _MD_CHESS_OFFERED_DRAW;
                }
                break;

            case _CHESS_MOVETYPE_ACCEPT_DRAW:
                if ($user_is_player && !empty($gamedata['offer_draw']) && $gamedata['offer_draw'] != $user_color && !$selfplay) {
                    $gamedata['offer_draw']   = '';
                    $gamedata['pgn_result']   = '1/2-1/2';
                    $comment                  = '{' . _MD_CHESS_DRAW_BY_AGREEMENT . '}';
                    $gamedata['pgn_movetext'] = str_replace('*', "{$gamedata['pgn_result']} $comment", $gamedata['pgn_movetext']);
                    $gamedata_updated         = true;
                    $notify                   = "$user_color_name " . _MD_CHESS_ACCEPTED_DRAW;
                }

                // no break
            case _CHESS_MOVETYPE_REJECT_DRAW:
                if ($user_is_player && !empty($gamedata['offer_draw']) && $gamedata['offer_draw'] != $user_color && !$selfplay) {
                    $gamedata['offer_draw']   = '';
                    $gamedata_updated         = true;
                    $notify                   = "$user_color_name " . _MD_CHESS_REJECTED_DRAW;
                }
                break;

            case _CHESS_MOVETYPE_RESTART:
                if ($user_is_player && $selfplay) {

                    // instantiate a ChessGame to get a "fresh" gamestate
                    $chessgame                                = new ChessGame($gamedata['pgn_fen']);
                    $new_gamestate                            = $chessgame->gamestate();

                    // update the game data
                    $gamedata['fen_piece_placement']          = $new_gamestate['fen_piece_placement'];
                    $gamedata['fen_active_color']             = $new_gamestate['fen_active_color'];
                    $gamedata['fen_castling_availability']    = $new_gamestate['fen_castling_availability'];
                    $gamedata['fen_en_passant_target_square'] = $new_gamestate['fen_en_passant_target_square'];
                    $gamedata['fen_halfmove_clock']           = $new_gamestate['fen_halfmove_clock'];
                    $gamedata['fen_fullmove_number']          = $new_gamestate['fen_fullmove_number'];
                    $gamedata['pgn_fen']                      = $new_gamestate['pgn_fen'];
                    $gamedata['pgn_result']                   = $new_gamestate['pgn_result'];
                    $gamedata['pgn_movetext']                 = $new_gamestate['pgn_movetext'];

                    // update user color
                    $user_color                               = $gamedata['fen_active_color'];

                    $gamedata_updated                         = true;
                }
                break;

            case _CHESS_MOVETYPE_DELETE:
                if ($user_is_player && ($selfplay || chess_can_delete())) {
                    $delete_game = true; // must defer actual deletion until after notifications are sent
                    $notify      = eval('return "' ._MD_CHESS_DELETED_GAME. '";'); // eval references $username
                }
                break;

            case _CHESS_MOVETYPE_WANT_ARBITRATION:
                if ($user_is_player) {

                    // Ensure that $move_explain does not contain separator $sep.
                    $sep = '|';
                    $move_explain = str_replace($sep, '_', $move_explain);

                    $gamedata['suspended'] = implode($sep, array(date('Y-m-d H:i:s'), $uid, _CHESS_MOVETYPE_WANT_ARBITRATION, $move_explain));
                    $gamedata_updated      = true;
                    $notify = "$user_color_name " . _MD_CHESS_RQSTED_ARBT . ' ' . _MD_CHESS_BEEN_SUSPENDED;
                }
                break;
        }
    }

    // If board orientation setting uninitialized or invalid, set it to the appropriate default.
    if (!in_array($orientation, array(_CHESS_ORIENTATION_ACTIVE, _CHESS_ORIENTATION_WHITE, _CHESS_ORIENTATION_BLACK))) {
        if ($user_is_player && $user_color == 'b') {
            $orientation = _CHESS_ORIENTATION_BLACK;
        } else {
            $orientation = _CHESS_ORIENTATION_WHITE;
        }
    }

    // Determine if user is a valid arbiter.
    global $xoopsModule;
    $is_arbiter = is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'));

    // If arbiter action was submitted, and user is a valid arbiter, process the action.
    if ($submit_arbitrate && $is_arbiter) {
        $username =  $xoopsUser ? $xoopsUser->getVar('uname') : '*unknown*';

        switch ($arbiter_action) {

            case _CHESS_ARBITER_RESUME:
                if ($gamedata['suspended'] && $gamedata['pgn_result'] == '*') {
                    $gamedata['suspended'] = '';
                    $gamedata_updated      = true;
                    $notify                = eval('return "' ._MD_CHESS_RESUMED_PLAY. '";'); // eval references $username
                }
                break;

            case _CHESS_ARBITER_DRAW:
                if ($gamedata['suspended'] && $gamedata['pgn_result'] == '*') {
                    $gamedata['offer_draw']   = '';
                    $gamedata['pgn_result']   = '1/2-1/2';
                    $arbiter_explain          = str_replace('{', '(', $arbiter_explain);
                    $arbiter_explain          = str_replace('}', ')', $arbiter_explain);
                    $comment                  = '{' . sprintf(_MD_CHESS_DRAW_DECLARED, $arbiter_explain) . '}';
                    $gamedata['pgn_movetext'] = str_replace('*', "{$gamedata['pgn_result']} $comment", $gamedata['pgn_movetext']);
                    $gamedata['suspended']    = '';
                    $gamedata_updated         = true;
                    $notify                   = eval('return "' ._MD_CHESS_DECLARED_DRAW. '";'); // eval references $username
                }
                break;

            case _CHESS_ARBITER_DELETE:
                if ($gamedata['suspended']) {
                    $delete_game = true; // must defer actual deletion until after notifications are sent
                    $notify      = eval('return "' ._MD_CHESS_DELETED_GAME. '";'); // eval references $username
                }
                break;

            case _CHESS_ARBITER_SUSPEND:
                if (!$gamedata['suspended'] && $gamedata['pgn_result'] == '*') {

                    // Ensure that $arbiter_explain does not contain separator $sep.
                    $sep = '|';
                    $arbiter_explain = str_replace($sep, '_', $arbiter_explain);

                    $gamedata['suspended'] = implode('|', array(date('Y-m-d H:i:s'), $uid, _CHESS_MOVETYPE_ARBITER_SUSPEND, $arbiter_explain));
                    $gamedata_updated      = true;
                    $notify                = eval('return "' ._MD_CHESS_SUSPENDED_PLAY. '";'); // eval references $username
                }
                break;

            default:
                break;
        }
    }

    // Store the updated game data in the database.
    if ($gamedata_updated) {
        chess_put_game($game_id, $gamedata);
    }

    // Display the (possibly updated) board.
    if (!$delete_game) {
        chess_show_board($gamedata, $orientation, $user_color, $move_performed, $move_result_text, $draw_claim_error_text, $show_arbiter_ctrl && $is_arbiter);
    }

    // If a move (or other action) was made, notify any subscribers.
    if (!empty($notify)) {
        $notificationHandler = xoops_getHandler('notification');

        $notificationHandler->triggerEvent('game', $game_id, 'notify_game_move', array('CHESS_ACTION' => $notify));

        // admin notifications
        if ($movetype == _CHESS_MOVETYPE_WANT_ARBITRATION) {
            $event      = 'notify_request_arbitration';
            $username   =  $xoopsUser ? $xoopsUser->getVar('uname') : '(' ._MD_CHESS_UNKNOWN. ')';
            $extra_tags = array('CHESS_REQUESTOR' => $username, 'CHESS_GAME_ID' => $game_id, 'CHESS_EXPLAIN' => $move_explain);
            $notificationHandler->triggerEvent('global', 0, $event, $extra_tags);
        }
    }

    // Handle delete-game action.
    if ($delete_game) {
        chess_delete_game($game_id);
        redirect_header(XOOPS_URL.'/modules/chess/', _CHESS_REDIRECT_DELAY_SUCCESS, _MD_CHESS_GAME_DELETED);
    }
}

/**
 * Fetch game data from database.
 *
 * @param int $game_id  Game ID
 * @return array  Game data
 */
function chess_get_game($game_id)
{
    global $xoopsDB;

    $games_table = $xoopsDB->prefix('chess_games');
    $result      = $xoopsDB->query("SELECT * FROM $games_table WHERE game_id = '$game_id'");
    $gamedata    = $xoopsDB->fetchArray($result);
    #var_dump('chess_get_game, gamedata', $gamedata);#*#DEBUG#
    $xoopsDB->freeRecordSet($result);

    return $gamedata;
}

/**
 * Store game data in database.
 *
 * @param int   $game_id  Game ID
 * @param array $gamedata  Game data
 */
function chess_put_game($game_id, $gamedata)
{
    global $xoopsDB;

    $myts = myTextSanitizer::getInstance();
    $suspended_q = $myts->addslashes($gamedata['suspended']);
    $movetext_q  = $myts->addslashes($gamedata['pgn_movetext']);

    $table  = $xoopsDB->prefix('chess_games');
    #echo "updating database table $table<br>\n";#*#DEBUG#
    $xoopsDB->query(trim("
		UPDATE $table
		SET
			start_date                   = '{$gamedata['start_date']}',
			last_date                    = '{$gamedata['last_date']}',
			fen_piece_placement          = '{$gamedata['fen_piece_placement']}',
			fen_active_color             = '{$gamedata['fen_active_color']}',
			fen_castling_availability    = '{$gamedata['fen_castling_availability']}',
			fen_en_passant_target_square = '{$gamedata['fen_en_passant_target_square']}',
			fen_halfmove_clock           = '{$gamedata['fen_halfmove_clock']}',
			fen_fullmove_number          = '{$gamedata['fen_fullmove_number']}',
			pgn_result                   = '{$gamedata['pgn_result']}',
			pgn_movetext                 = '$movetext_q',
			offer_draw                   = '{$gamedata['offer_draw']}',
			suspended                    = '$suspended_q',
			white_confirm                = '{$gamedata['white_confirm']}',
			black_confirm                = '{$gamedata['black_confirm']}'
		WHERE  game_id = '$game_id'
	"));
    if ($xoopsDB->errno()) {
        trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);
    }

    if ($gamedata['pgn_result'] != '*' && $gamedata['is_rated'] == '1') {
        require_once XOOPS_ROOT_PATH . '/modules/chess/include/ratings.inc.php';
        chess_ratings_adj($game_id);
    }
}

/**
 * Delete game from database.
 *
 * @param int $game_id  Game ID
 */
function chess_delete_game($game_id)
{
    global $xoopsModule, $xoopsDB;

    // delete notifications associated with this game
    xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'game', $game_id);

    $table = $xoopsDB->prefix('chess_games');
    $xoopsDB->query("DELETE FROM $table WHERE game_id='$game_id'");
    if ($xoopsDB->errno()) {
        trigger_error($xoopsDB->errno() . ':' . $xoopsDB->error(), E_USER_ERROR);
    }
}

/**
 * Handle a move.
 *
 * @param array $gamedata  Game data (input/output)
 * @param string $move  The move
 * @return array A two-element array:
 *  - $move_performed: true if the move was performed and the game state has been updated, false otherwise
 *  - $move_result_text: text message
 */
function chess_move(&$gamedata, $move)
{
    $gamestate = array(
        'fen_piece_placement'          => $gamedata['fen_piece_placement'],
        'fen_active_color'             => $gamedata['fen_active_color'],
        'fen_castling_availability'    => $gamedata['fen_castling_availability'],
        'fen_en_passant_target_square' => $gamedata['fen_en_passant_target_square'],
        'fen_halfmove_clock'           => $gamedata['fen_halfmove_clock'],
        'fen_fullmove_number'          => $gamedata['fen_fullmove_number'],
        'pgn_fen'                      => $gamedata['pgn_fen'],
        'pgn_result'                   => $gamedata['pgn_result'],
        'pgn_movetext'                 => $gamedata['pgn_movetext'],
    );

    $chessgame = new ChessGame($gamestate);

    #echo "Performing move: '$move'<br>\n";#*#DEBUG#
    [$move_performed, $move_result_text] = $chessgame->move($move);
    #echo "Move result: '$move_result_text'<br>\n";#*#DEBUG#

    if ($move_performed) {

        // The move was valid - update the game data.

        $new_gamestate = $chessgame->gamestate();
        #var_dump('new_gamestate', $new_gamestate);#*#DEBUG#

        #*#DEBUG# - start
        #if ($new_gamestate['fen_castling_availability'] != $gamedata['fen_castling_availability']) {
        #	echo "*** castling_availability changed from '{$gamedata['fen_castling_availability']}' to '{$new_gamestate['fen_castling_availability']}' ***<br>\n";
        #}
        #*#DEBUG# - end

        $gamedata['fen_piece_placement']          = $new_gamestate['fen_piece_placement'];
        $gamedata['fen_active_color']             = $new_gamestate['fen_active_color'];
        $gamedata['fen_castling_availability']    = $new_gamestate['fen_castling_availability'];
        $gamedata['fen_en_passant_target_square'] = $new_gamestate['fen_en_passant_target_square'];
        $gamedata['fen_halfmove_clock']           = $new_gamestate['fen_halfmove_clock'];
        $gamedata['fen_fullmove_number']          = $new_gamestate['fen_fullmove_number'];
        $gamedata['pgn_fen']                      = $new_gamestate['pgn_fen'];
        $gamedata['pgn_result']                   = $new_gamestate['pgn_result'];
        $gamedata['pgn_movetext']                 = $new_gamestate['pgn_movetext'];

        $gamedata['last_date'] = date('Y-m-d H:i:s');

        // if start_date undefined (first move), initialize it
        if ($gamedata['start_date'] == '0000-00-00 00:00:00') {
            $gamedata['start_date'] = $gamedata['last_date'];
        }
    }

    return array($move_performed, $move_result_text);
}

/**
 * Verify a draw-claim under the 50-move rule.
 *
 * @param array $gamedata  Game data
 * @return array  A two-element array:
 *  - $draw_claim_valid: True if draw-claim is valid, otherwise false
 *  - $draw_claim_text: Describes draw-claim result
 */
function chess_is_draw_50_move_rule($gamedata)
{
    #var_dump('gamedata', $gamedata);#*#DEBUG#

    if ($gamedata['fen_halfmove_clock'] >= 100) {
        $draw_claim_valid = true;
        $draw_claim_text  = _MD_CHESS_DRAW_50;
    } else {
        $draw_claim_valid = false;
        $draw_claim_text  = _MD_CHESS_NO_DRAW_50;
    }

    return array($draw_claim_valid, $draw_claim_text);
}

/**
 * Verify a draw-claim under the threefold-repetition rule.
 *
 * Board positions are compared using the first four fields of the FEN data:
 * fen_piece_placement, fen_active_color, fen_castling_availability and fen_en_passant_target_square.
 *
 * @param array $gamedata  Game data
 * @return array  A two-element array:
 *  - $draw_claim_valid: True if draw-claim is valid, otherwise false
 *  - $draw_claim_text: Describes draw-claim result
 */
function chess_is_draw_threefold_repetition($gamedata)
{
    #var_dump('gamedata', $gamedata);#*#DEBUG#

    // Define this constant as true to output a log file containing a move analysis.
    define('CHESS_LOG_3FOLD', false);
    if (CHESS_LOG_3FOLD) {
        $log = array();
    }

    $chessgame = new ChessGame($gamedata);

    // board position against which to check for repetitions
    $last_board_state = "{$gamedata['fen_piece_placement']} {$gamedata['fen_active_color']} {$gamedata['fen_castling_availability']} {$gamedata['fen_en_passant_target_square']}";
    $last_move_number = $gamedata['fen_fullmove_number'];
    #echo "last_board_state='$last_board_state'<br>\n";#*#DEBUG#
    if (CHESS_LOG_3FOLD) {
        $log[] = sprintf("%08x %03d%1s %s", crc32($last_board_state), $gamedata['fen_fullmove_number'], $gamedata['fen_active_color'], $last_board_state);
    }

    $chessgame = new ChessGame($gamedata['pgn_fen']);
    empty($chessgame->error) or trigger_error('chessgame invalid', E_USER_ERROR);

    $tmp_gamedata = $chessgame->gamestate();
    is_array($tmp_gamedata) or trigger_error('gamestate invalid', E_USER_ERROR);

    #*#DEBUG# - start
    /***
        if (function_exists('posix_times')) {
            $posix_times = posix_times();
            var_dump('posix_times', $posix_times);
        }
        if (function_exists('getrusage')) {
            $rusage = getrusage();
            var_dump('rusage', $rusage);
        }
    ***/
    #*#DEBUG# - end

    // $repeats is the list of moves for which the board positions are identical.
    // For example, '6w' would represent the board position immediately before white's sixth move.
    // The current position is included, since that's the position against which the other positions will be compared.
    $repeats[] = $gamedata['fen_fullmove_number'] . $gamedata['fen_active_color'];

    // Compare initial board position with last board position, unless the move number is the same, meaning that there haven't been any moves.
    #echo "FEN: '{$tmp_gamedata['fen_piece_placement']} {$tmp_gamedata['fen_active_color']} {$tmp_gamedata['fen_castling_availability']} {$tmp_gamedata['fen_en_passant_target_square']} {$tmp_gamedata['fen_halfmove_clock']} {$tmp_gamedata['fen_fullmove_number']}'<br>\n";#*#DEBUG#
    $board_state = "{$tmp_gamedata['fen_piece_placement']} {$tmp_gamedata['fen_active_color']} {$tmp_gamedata['fen_castling_availability']} {$tmp_gamedata['fen_en_passant_target_square']}";
    if ($tmp_gamedata['fen_fullmove_number'] != $last_move_number && $board_state == $last_board_state) {
        $repeats[] = $tmp_gamedata['fen_fullmove_number'] . $tmp_gamedata['fen_active_color'];
        if (CHESS_LOG_3FOLD) {
            $log[] = sprintf("%08x %03d%1s %s", crc32($board_state), $tmp_gamedata['fen_fullmove_number'], $tmp_gamedata['fen_active_color'], $board_state);
        }
        #*#DEBUG# - start
/***
        if (count($repeats) >= 3) {
            echo "*** Three repetitions! {$repeats[1]},{$repeats[2]},{$repeats[0]} ***<br>\n";
        } elseif (count($repeats) >= 2) {
            echo "*** Two repetitions!  {$repeats[1]},{$repeats[0]} ***<br>\n";
        }
***/
#*#DEBUG# - end
    }

    // Convert pgn_movetext into Nx3 array $movelist.
    $movelist = chess_make_movelist($gamedata['pgn_movetext']);
    #var_dump('movelist', $movelist);#*#DEBUG#

    // Compare board positions after each move with last board position.
    foreach ($movelist as $fullmove) {

        #echo "'{$fullmove[0]}' '{$fullmove[1]}' '{$fullmove[2]}'<br>\n";#*#DEBUG#
        if (CHESS_LOG_3FOLD) {
            #$log[] = "'{$fullmove[0]}' '{$fullmove[1]}' '{$fullmove[2]}'";#*#LOG_3FOLD# #*#DEBUG#
        }

        for ($i = 1; $i <= 2; ++$i) {
            if (!empty($fullmove[$i])) {
                $move = $fullmove[$i];
            } else {
                continue; // $fullmove[$i] can be empty if last move was white's, or if game was setup with black to move first.
            }

            // Remove check/checkmate annotation, if present.
            $move = str_replace('+', '', $move);
            $move = str_replace('#', '', $move);

            #echo "Performing move: '$move'<br>\n";#*#DEBUG#
            [$tmp_move_performed, $tmp_move_result_text] = $chessgame->move($move);
            #echo "Move result: '$tmp_move_result_text'<br>\n";#*#DEBUG#
            $tmp_move_performed or trigger_error("Failed to perform move $move: $tmp_move_result_text", E_USER_ERROR);
            $tmp_gamedata = $chessgame->gamestate();
            #echo "FEN: '{$tmp_gamedata['fen_piece_placement']} {$tmp_gamedata['fen_active_color']} {$tmp_gamedata['fen_castling_availability']} {$tmp_gamedata['fen_en_passant_target_square']} {$tmp_gamedata['fen_halfmove_clock']} {$tmp_gamedata['fen_fullmove_number']}'<br>\n";#*#DEBUG#
            $board_state = "{$tmp_gamedata['fen_piece_placement']} {$tmp_gamedata['fen_active_color']} {$tmp_gamedata['fen_castling_availability']} {$tmp_gamedata['fen_en_passant_target_square']}";
            if (CHESS_LOG_3FOLD) {
                $log[] = sprintf("%08x %03d%1s %s", crc32($board_state), $tmp_gamedata['fen_fullmove_number'], $tmp_gamedata['fen_active_color'], $board_state);
            }
            if ($tmp_gamedata['fen_fullmove_number'] != $last_move_number && $board_state == $last_board_state) {
                $repeats[] = $tmp_gamedata['fen_fullmove_number'] . $tmp_gamedata['fen_active_color'];
                #*#DEBUG# - start
                /***
                                if (count($repeats) >= 3) {
                                    echo "*** Three repetitions! {$repeats[1]},{$repeats[2]},{$repeats[0]} ***<br>\n";
                                } elseif (count($repeats) >= 2) {
                                    echo "*** Two repetitions!  {$repeats[1]},{$repeats[0]} ***<br>\n";
                                }
                ***/
                #*#DEBUG# - end
                if (count($repeats) >= 3) {
                    break 2;
                }
            }
        }
    }

    #*#DEBUG# - start
    /***
        if (function_exists('posix_times')) {
            $posix_times = posix_times();
            var_dump('posix_times', $posix_times);
        }
        if (function_exists('getrusage')) {
            $rusage = getrusage();
            var_dump('rusage', $rusage);
        }
    ***/
    #*#DEBUG# - end

    if (count($repeats) >= 3) {
        $draw_claim_valid = true;
        $draw_claim_text  = sprintf(_MD_CHESS_DRAW_3, "{$repeats[1]},{$repeats[2]},{$repeats[0]}");
    } else {
        $draw_claim_valid = false;
        $draw_claim_text  = _MD_CHESS_NO_DRAW_3;
    }

    if (CHESS_LOG_3FOLD) {
        $logfile = XOOPS_ROOT_PATH . '/cache/' . date('Ymd_His') . '_3fold.log';
        sort($log);
        error_log(implode("\n", $log), 3, $logfile);
    }

    return array($draw_claim_valid, $draw_claim_text);
}

/**
 * Convert pgn_movetext into Nx3 array.
 *
 * @param array $movetext pgn_movetext
 * @return array Nx3 array
 */
function chess_make_movelist($movetext)
{
    $movelist    = array();
    $move_tokens = explode(' ', preg_replace('/\{.*\}/', '', $movetext));
    $index       = -1;
    while ($move_tokens) {
        $move_token = array_shift($move_tokens);
        if (in_array($move_token, array('1-0', '0-1', '1/2-1/2', '*'))) {
            break;
        } elseif (preg_match('/^\d+(\.|\.\.\.)$/', $move_token, $matches)) {
            ++$index;
            $movelist[$index][] = $move_token;
            if ($matches[1] == '...') { // setup-game with initial black move - add padding for white's move
                $movelist[$index][] = '';
            }
        } else {
            $movelist[$index][] = $move_token;
        }
    }

    return $movelist;
}

/**
 * Display chess board.
 *
 * @param array  $gamedata               Game data
 * @param string $orientation            _CHESS_ORIENTATION_ACTIVE, _CHESS_ORIENTATION_WHITE or _CHESS_ORIENTATION_BLACK
 * @param string $user_color             'w', 'b' or '' (empty string indicates that current user is not a player in this game)
 * @param bool   $move_performed         True if move was performed
 * @param string $move_result_text       Text describing move
 * @param string $draw_claim_error_text  Non-empty if draw claim invalid
 * @param bool   $show_arbiter_ctrl      True if arbiter controls are to be displayed
 */
function chess_show_board($gamedata, $orientation, $user_color, $move_performed, $move_result_text = '', $draw_claim_error_text = '', $show_arbiter_ctrl = false)
{
    global $xoopsTpl;

    $xoopsTpl->assign('xoops_module_header', '
		<link rel="stylesheet" type="text/css" media="screen" href="' .XOOPS_URL. '/modules/chess/include/style.css">
	');

    $memberHandler = xoops_getHandler('member');
    $white_user     = $memberHandler->getUser($gamedata['white_uid']);
    $white_username =  is_object($white_user) ? $white_user->getVar('uname') : '?';
    $black_user     = $memberHandler->getUser($gamedata['black_uid']);
    $black_username =  is_object($black_user) ? $black_user->getVar('uname') : '?';

    // Determine whether board is flipped (black at bottom) or "normal" (white at bottom).
    switch ($orientation) {
        default:
        case _CHESS_ORIENTATION_ACTIVE:
            $flip = $gamedata['fen_active_color'] == 'b';
            break;
        case _CHESS_ORIENTATION_WHITE:
            $flip = false;
            break;
        case _CHESS_ORIENTATION_BLACK:
            $flip = true;
            break;
    }

    // Convert fen_piece_placement string into 8x8-array $tiles.
    $tiles = array();
    $ranks = explode('/', $gamedata['fen_piece_placement']);
    if ($flip) {
        $ranks = array_reverse($ranks);
    }
    foreach ($ranks as $rank) {
        $expanded_row = preg_replace_callback(
            '/(\d)/',
            create_function(
                '$matches',
                'return str_repeat(\'x\', $matches[1]);'
            ),
            $rank
        );
        $rank_tiles = preg_split('//', $expanded_row, -1, PREG_SPLIT_NO_EMPTY);
        $tiles[] = $flip ? array_reverse($rank_tiles) : $rank_tiles;
    }

    #var_dump('tiles', $tiles);#*#DEBUG#

    // Convert pgn_movetext into Nx3 array $movelist.
    $movelist = chess_make_movelist($gamedata['pgn_movetext']);

    static $file_labels = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h');
    if ($flip) {
        $file_labels = array_reverse($file_labels);
    }

    $xoopsTpl->assign('chess_gamedata', $gamedata);

    // comment at end of movetext
    if (preg_match('/\{(.*?)\}\s*$/', $gamedata['pgn_movetext'], $matches)) {
        $xoopsTpl->assign('chess_result_comment', $matches[1]);
    } else {
        $xoopsTpl->assign('chess_result_comment', '');
    }

    $xoopsTpl->assign('chess_create_date', $gamedata['create_date'] != '0000-00-00 00:00:00' ? strtotime($gamedata['create_date']) : 0);
    $xoopsTpl->assign('chess_start_date', $gamedata['start_date']  != '0000-00-00 00:00:00' ? strtotime($gamedata['start_date'])  : 0);
    $xoopsTpl->assign('chess_last_date', $gamedata['last_date']   != '0000-00-00 00:00:00' ? strtotime($gamedata['last_date'])   : 0);
    $xoopsTpl->assign('chess_white_user', $white_username);
    $xoopsTpl->assign('chess_black_user', $black_username);
    $xoopsTpl->assign('chess_tiles', $tiles);
    $xoopsTpl->assign('chess_file_labels', $file_labels);

    $xoopsTpl->assign(
        'chess_pgn_string',
        chess_to_pgn_string(
            array(
                'event'    => '?',
                'site'     => $_SERVER['SERVER_NAME'],
                'datetime' => $gamedata['start_date'],
                'round'    => '?',
                'white'    => $white_username,
                'black'    => $black_username,
                'result'   => $gamedata['pgn_result'],
                'setup'    => !empty($gamedata['pgn_fen']) ? 1 : 0,
                'fen'      => $gamedata['pgn_fen'],
                'movetext' => $gamedata['pgn_movetext'],
            )
        )
    );

    $xoopsTpl->assign('chess_movelist', $movelist);
    $xoopsTpl->assign('chess_date_format', _MEDIUMDATESTRING);

    #if (empty($move_result_text)) {$move_result_text = 'test';}#*#DEBUG#
    $xoopsTpl->assign('chess_move_performed', $move_performed);
    $xoopsTpl->assign('chess_move_result', $move_result_text);

    $xoopsTpl->assign('chess_draw_claim_error_text', $draw_claim_error_text);

    $xoopsTpl->assign('chess_user_color', $user_color);

    $xoopsTpl->assign('chess_confirm', $gamedata[$user_color == 'w' ? 'white_confirm' : 'black_confirm']);
    $xoopsTpl->assign('chess_orientation', $orientation);

    $xoopsTpl->assign('chess_rank_start', $flip ? 1      : 8);
    $xoopsTpl->assign('chess_rank_direction', $flip ? 'up'   : 'down');

    $xoopsTpl->assign('chess_file_start', $flip ? 8      : 1);
    $xoopsTpl->assign('chess_file_direction', $flip ? 'down' : 'up');

    static $pieces = array(
        'K' => array('color' => 'w', 'name' => 'wking',   'alt' => _MD_CHESS_ALT_WKING),
        'Q' => array('color' => 'w', 'name' => 'wqueen',  'alt' => _MD_CHESS_ALT_WQUEEN),
        'R' => array('color' => 'w', 'name' => 'wrook',   'alt' => _MD_CHESS_ALT_WROOK),
        'B' => array('color' => 'w', 'name' => 'wbishop', 'alt' => _MD_CHESS_ALT_WBISHOP),
        'N' => array('color' => 'w', 'name' => 'wknight', 'alt' => _MD_CHESS_ALT_WKNIGHT),
        'P' => array('color' => 'w', 'name' => 'wpawn',   'alt' => _MD_CHESS_ALT_WPAWN),
        'k' => array('color' => 'b', 'name' => 'bking',   'alt' => _MD_CHESS_ALT_BKING),
        'q' => array('color' => 'b', 'name' => 'bqueen',  'alt' => _MD_CHESS_ALT_BQUEEN),
        'r' => array('color' => 'b', 'name' => 'brook',   'alt' => _MD_CHESS_ALT_BROOK),
        'b' => array('color' => 'b', 'name' => 'bbishop', 'alt' => _MD_CHESS_ALT_BBISHOP),
        'n' => array('color' => 'b', 'name' => 'bknight', 'alt' => _MD_CHESS_ALT_BKNIGHT),
        'p' => array('color' => 'b', 'name' => 'bpawn',   'alt' => _MD_CHESS_ALT_BPAWN),
        'x' => array('color' => 'x', 'name' => 'empty',   'alt' => _MD_CHESS_ALT_EMPTY),
    );
    $xoopsTpl->assign('chess_pieces', $pieces);

    $xoopsTpl->assign('chess_show_arbitration_controls', $show_arbiter_ctrl);

    if ($show_arbiter_ctrl && $gamedata['suspended']) {
        [$susp_date, $susp_uid, $susp_type, $susp_explain] = explode('|', $gamedata['suspended']);
        switch ($susp_type) {
            case 'arbiter_suspend':
                $susp_type_display = _MD_CHESS_SUSP_TYPE_ARBITER;
                break;
            case 'want_arbitration':
                $susp_type_display = _MD_CHESS_SUSP_TYPE_PLAYER;
                break;
            default:
                $susp_type_display = _MD_CHESS_LABEL_ERROR;
                break;
        }
        $susp_user     = $memberHandler->getUser($susp_uid);
        $susp_username =  is_object($susp_user) ? $susp_user->getVar('uname') : _MD_CHESS_UNKNOWN;
        $suspend_info = array(
            'date'   => strtotime($susp_date),
            'user'   => $susp_username,
            'type'   => $susp_type_display,
            'reason' => $susp_explain,
        );
        $xoopsTpl->assign('chess_suspend_info', $suspend_info);
    }

    // Initialize $captured_pieces_all to indicate all pieces captured, then subtract off the pieces remaining on the board.
    $captured_pieces_all = array(
        'Q' => 1, 'R' => 2, 'B' => 2, 'N' => 2, 'P' => 8,
        'q' => 1, 'r' => 2, 'b' => 2, 'n' => 2, 'p' => 8,
    );
    for ($i = 0; $i < strlen($gamedata['fen_piece_placement']); ++$i) {
        $piece = $gamedata['fen_piece_placement']{$i};
        if (!empty($captured_pieces_all[$piece])) {
            --$captured_pieces_all[$piece];
        }
    }

    // Construct lists of white's and black's captured pieces.
    $captured_pieces = array('white' => array(), 'black' => array());
    foreach ($captured_pieces_all as $piece => $count) {
        if ($count > 0) {
            if (ctype_upper($piece)) {
                $captured_pieces['white'] = array_merge($captured_pieces['white'], array_pad(array(), $count, $piece));
            } elseif (ctype_lower($piece)) {
                $captured_pieces['black'] = array_merge($captured_pieces['black'], array_pad(array(), $count, $piece));
            }
        }
    }
    #var_dump('captured_pieces_all', $captured_pieces_all);#*#DEBUG#
    #var_dump('captured_pieces', $captured_pieces);#*#DEBUG#
    $xoopsTpl->assign('chess_captured_pieces', $captured_pieces);

    $xoopsTpl->assign('chess_pawn_promote_choices', $gamedata['fen_active_color'] == 'w' ? array('Q','R','B','N') : array('q','r','b','n'));

    $xoopsTpl->assign('chess_allow_delete', chess_can_delete());

    // popup window contents for selecting piece to which pawn is promoted
    // (Note that template is compiled here by fetch(), so any template variables it uses must already be defined.)
    $xoopsTpl->assign('chess_pawn_promote_popup', $user_color ? $xoopsTpl->fetch('db:chess_game_promote_popup.tpl') : '');

    $xoopsTpl->assign('chess_ratings_enabled', chess_moduleConfig('rating_system') != 'none');

    // security token
    $xoopsTpl->assign('chess_xoops_request_token', is_object($GLOBALS['xoopsSecurity']) ? $GLOBALS['xoopsSecurity']->getTokenHTML() : '');
}
