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
//  The CXR Rating System algorithm is used by permission of Chess Express   //
//  Ratings, Inc. <http://chess-express.com/>.                               //
//  ------------------------------------------------------------------------ //

/**
 * Ratings functions specific to CXR rating system.
 *
 * @package chess
 * @subpackage ratings
 */

/**
 * Update the players' ratings for an individual game, using the CXR rating system.
 *
 * @param int    $white_rating  White's current rating
 * @param int    $white_games   Number of rated games that white has played
 * @param int    $black_rating  Black's current rating
 * @param int    $black_games   Number of rated games that black has played
 * @param string $pgn_result    Game result: '1-0' (white won), '0-1' (black won) or '1/2-1/2' (draw)
 * @return array  Array with two elements:
 *  - $white_rating_new - white's new rating
 *  - $black_rating_new - black's new rating
 */
function chess_ratings_adj_cxr($white_rating, $white_games, $black_rating, $black_games, $pgn_result)
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

    if (($white_games < 5 && $black_games < 5) || ($white_games > 5 && $black_games > 5)) {

        // Formula 1: Rnew = Rold + (S x 21) + (Ropponent - Rold) / 25
        $w_new = ($S * 21) + ($black_rating - $white_rating) / 25;
        $b_new = (-$S * 21) + ($white_rating - $black_rating) / 25;
    } elseif ($white_games > 5 && $black_games < 5) {

        // Formula 2: Rnew = Rold + (S x 6) + (Ropponent - Rold) / 100
        $w_new = ($S * 6) + ($black_rating - $white_rating) / 100;

        // Formula 3: Rnew = (4/5) x Rold + (1/5) x Ropponent + (S x 80)
        $b_new = ($white_rating / 5) + ($S * -80) - ($black_rating / 5);
    } else {

        // Formula 2: Rnew = Rold + (S x 6) + (Ropponent - Rold) / 100
        $b_new = ($S * 6) + ($white_rating - $black_rating) / 100;

        // Formula 3: Rnew = (4/5) x Rold + (1/5) x Ropponent + (S x 80)
        $w_new = ($black_rating / 5) + ($S * -80) - ($white_rating / 5);
    }

    // Rule R1: The winning rated player must gain at least two points.
    // Rule R2: The losing rated player must lose at least two points.
    if (abs($w_new) < 2) {
        $w_new = $S * 2;
    }
    if (abs($b_new) < 2) {
        $b_new = $S * -2;
    }

    // Rule R3: The rated player must not gain nor lose more than 41 points.
    if (abs($w_new) > 41) {
        $w_new = $S * 41;
    }
    if (abs($b_new) > 41) {
        $b_new = $S * -41;
    }
  
    if ($S == 1) {
        if ($white_games < 5 && $w_new < 0) {
            $w_new = 2;
        }
        if ($black_games < 5 && $b_new > 0) {
            $b_new = -2;
        }
    } elseif ($S == -1) {
        if ($white_games < 5 && $w_new > 0) {
            $w_new = -2;
        }
        if ($black_games < 5 && $b_new < 0) {
            $b_new = 2;
        }
    }

    return array($white_rating + $w_new, $black_rating + $b_new);
}

/**
 * Get the number of provisional games used in the CXR rating system.
 *
 * @return int  Number of provisional games
 */
function chess_ratings_num_provisional_games_cxr()
{
    return 5;
}
