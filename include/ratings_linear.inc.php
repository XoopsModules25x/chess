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
 * Ratings functions specific to Linear rating system.
 *
 * @package    chess
 * @subpackage ratings
 */

/**
 * Update the players' ratings for an individual game, using the Linear rating system.
 *
 * @param int    $white_rating White's current rating
 * @param int    $white_games  Number of rated games that white has played
 * @param int    $black_rating Black's current rating
 * @param int    $black_games  Number of rated games that black has played
 * @param string $pgn_result   Game result: '1-0' (white won), '0-1' (black won) or '1/2-1/2' (draw)
 * @return array  Array with two elements:
 *                             - $white_rating_new - white's new rating
 *                             - $black_rating_new - black's new rating
 */
function chess_ratings_adj_linear($white_rating, $white_games, $black_rating, $black_games, $pgn_result)
{
    // compute score: +1 for win, 0 for draw, -1 for loss
    switch ($pgn_result) {
        case '1-0':
            $S = 1;
            break;
        case '1/2-1/2':
        default: // should not occur
            $S = 0;
            break;
        case '0-1':
            $S = -1;
            break;
    }

    return [$white_rating + $S * 10, $black_rating - $S * 10];
}

/**
 * Get the number of provisional games used in the Linear rating system.
 *
 * @return int  Number of provisional games
 */
function chess_ratings_num_provisional_games_linear()
{
    return 2;
}

?>
