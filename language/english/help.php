<?php

/**
 * Language strings for help page (en)
 *
 * @package chess
 * @subpackage language
 */

/**#@+
 * @ignore
 */

// Note that quotes within the strings need to be escaped.

// --------------------

define('_HE_CHESS_MAIN_TITLE', 'Chess Help');

// --------------------

define('_HE_CHESS_INTRO_TITLE', 'Introduction');

define('_HE_CHESS_INTRO_010', '
This software is intended to comply with the <a href="http://fide.com/official/handbook.asp?level=EE1">Laws of Chess</a>
as stipulated by the F&eacute;d&eacute;ration Internationale des &Eacute;checs (International Chess Federation),
commonly known as FIDE.
');

// --------------------

define('_HE_CHESS_CREATE_TITLE', 'Creating new games');

define('_HE_CHESS_CREATE_010', '
There are three types of games that you may create:
');
define('_HE_CHESS_CREATE_010_1', 'Open challenge');
define('_HE_CHESS_CREATE_010_2', 'Individual challenge');
define('_HE_CHESS_CREATE_010_3', 'Self-play');

define('_HE_CHESS_CREATE_020', '
An <em>open challenge</em> may be accepted by anyone.
An <em>individual challenge</em> may only be accepted by a specified user.
A <em>self-play</em> game may be created if you wish to experiment with this software.
');

define('_HE_CHESS_CREATE_030', '
	You may optionally provide an initial board setup position using Forsyth-Edwards Notation (FEN).
');

define('_HE_CHESS_CREATE_040', '
You may specify that your opponent will choose the colors,
that the colors will be assigned randomly,
or you may choose a specific color.
');

define('_HE_CHESS_CREATE_050', '
	You may specify whether the game will be rated.
');

define('_HE_CHESS_CREATE_060', '
A challenge game will be created as soon as another user accepts the challenge.
A self-play game will be created immediately.
');

define('_HE_CHESS_CREATE_070', '
A challenger may delete his challenge at any time prior to its acceptance.
');

// --------------------

define('_HE_CHESS_RATINGS_TITLE', 'Player rating system');

define('_HE_CHESS_RATINGS_CXR',  '
	CXR - An adaptation of the ELO rating system, used by permission of <a target="_blank" href="http://chess-express.com/">Chess Express Ratings, Inc.</a>
');

define('_HE_CHESS_RATINGS_LINEAR',  '
	Linear - A very simple system that adds (subtracts) a fixed number of points for a win (loss).
');

// --------------------

define('_HE_CHESS_PLAY_TITLE', 'Playing a game');

define('_HE_CHESS_PLAY_010', '
A player can choose from the following actions.
Not all of these actions are available all of the time.
');
define('_HE_CHESS_PLAY_010_1', 'Normal move');
define('_HE_CHESS_PLAY_010_2', 'Claim draw');
define('_HE_CHESS_PLAY_010_3', 'Offer draw');
define('_HE_CHESS_PLAY_010_4', 'Accept draw');
define('_HE_CHESS_PLAY_010_5', 'Reject draw');
define('_HE_CHESS_PLAY_010_6', 'Resign');
define('_HE_CHESS_PLAY_010_7', 'Restart game');
define('_HE_CHESS_PLAY_010_8', 'Delete game');
define('_HE_CHESS_PLAY_010_9', 'Request arbitration');

define('_HE_CHESS_PLAY_020', '
You may make a <em>normal move</em> if it is your turn to move.
Moving is discussed in detail <a href="#moving">below</a>.
');

define('_HE_CHESS_PLAY_030', '
You may <em>claim a draw</em> if the conditions are satisfied for the 50-move rule or the threefold repetition rule,
and it is your turn to move.
You may optionally enter a (legal) move that will cause the conditions to be satisfied.
Note that this move <em>will be performed</em>.
If your claim is determined to be correct, the game will immediately end in a draw.
');

define('_HE_CHESS_PLAY_040', '
You may <em>offer a draw</em> either on your turn or on your opponent\'s turn.
You may not withdraw the offer.
Your opponent must either <em>accept</em> it or <em>reject</em> it.
If it is your opponent\'s turn, he may reject the offer by making a normal move.
If he accepts the offer, the game immediately ends in a draw.
Note that if you offer a draw on your opponent\'s turn,
he may not be aware of the offer if he\'s already viewing the board in preparation for his move.
You may not offer a draw in a self-play game.
');

define('_HE_CHESS_PLAY_050', '
You may <em>resign</em> either on your turn or on your opponent\'s turn.
This will immediately end the game, and your opponent will be the winner.
');

define('_HE_CHESS_PLAY_060', '
In a self-play game, you may <em>restart</em> the game at any time.
This will delete all moves made in the game and restart the game at its initial position.
');

define('_HE_CHESS_PLAY_070', '
You may <em>delete</em> the game at any time.
This will permanently remove the game from the database.
');

define('_HE_CHESS_PLAY_075', '
In a self-play game, you may <em>delete</em> the game at any time.
This will permanently remove the game from the database.
');

define('_HE_CHESS_PLAY_080', '
You may <em>request arbitration</em> either on your turn or on your opponent\'s turn.
This will immediately suspend the game so that an arbiter may review it.
This action may be used for any situation that warrants it, including software bugs.
Please provide a brief explanation in the area provided.
If a lengthy explanation is required, please indicate this with a comment such as "contact me for details".
');

define('_HE_CHESS_PLAY_090', '
If your browser is Javascript-enabled, a dialog will popup to <em>confirm</em> your move or other action.
If you prefer, you may disable that dialog by unchecking the Confirm checkbox.
(But remember, just like in "real" chess, once you make a move, you can\'t withdraw it.)
Your confirm-preference is specific to the current game;
i.e., changing that setting in one game will not affect the setting in other games that you\'re playing.
');

// --------------------

define('_HE_CHESS_ARBITRATION_TITLE', 'Suspended games and arbitration');

define('_HE_CHESS_ARBITRATION_010', '
While a game is suspended, no moves or other player actions can be made.
An arbiter will review the game and make a decision in compliance with the accepted Laws of Chess.
If necessary, the arbiter will consult the player(s) and/or seek advice elsewhere prior to making a decision.
The arbiter has the following actions available:
');

define('_HE_CHESS_ARBITRATION_010_1', 'Resume normal play');
define('_HE_CHESS_ARBITRATION_010_2', 'Declare draw');
define('_HE_CHESS_ARBITRATION_010_3', 'Delete game');

define('_HE_CHESS_ARBITRATION_020', '
When appropriate, an arbiter may also suspend a game that\'s in normal play.
');

// --------------------

define('_HE_CHESS_DISPLAY_TITLE', 'Board orientation and refreshing the display');

define('_HE_CHESS_DISPLAY_010', '
There are three choices for how the chess board is oriented:
');

define('_HE_CHESS_DISPLAY_010_1', 'Active color at bottom');
define('_HE_CHESS_DISPLAY_010_2', 'White at bottom');
define('_HE_CHESS_DISPLAY_010_3', 'Black at bottom');

define('_HE_CHESS_DISPLAY_020', '
When you view a game in which you\'re playing, your color is at the bottom by default.
Otherwise white is at the bottom by default.
');

define('_HE_CHESS_DISPLAY_030', '
If you change the orientation setting, click the <em>Refresh</em> button to effect the change.
The orientation setting will revert to the default if you leave the page and later return to it.
');

define('_HE_CHESS_DISPLAY_040', '
Note that if your opponent moves while you\'re viewing the board, your view will not automatically update.
You would need to use the Refresh button to update the board to see his move.
');

// --------------------

define('_HE_CHESS_NOTIFY_TITLE', 'Notifications and comments');

define('_HE_CHESS_NOTIFY_010', '
You can subscribe to any of several <em>Notification Options</em> related to chess games,
such as notification when a new move is made and notification when a new challenge game is created.
');

define('_HE_CHESS_NOTIFY_020', '
<em>Comments</em> may be posted for each game.
');

// --------------------

define('_HE_CHESS_MOUSE_TITLE', 'Moving (using the mouse)');

define('_HE_CHESS_MOUSE_010', '
Moves are made either by using a mouse (recommended), or by typing the notation for the move in the text box.
');

define('_HE_CHESS_MOUSE_020', '
To use the mouse, click on the piece to move, and then click on the destination tile.
(To castle, click on the king and its destination tile.)
Each tile clicked will be highlighted.
If a pawn is moved to the last rank, a dialog will popup for you to choose the piece to which to promote the pawn.
The notation for the move is automatically entered in the text box.
Finally, click the Submit button.
');

define('_HE_CHESS_MOUSE_030', '
Moving with the mouse requires that your browser be Javascript-enabled.
');

// --------------------

define('_HE_CHESS_NOTATION_TITLE', 'Moving (using notation)');

define('_HE_CHESS_NOTATION_010', '
As an alternative to using the mouse, you may enter moves by typing the notation in the text box.
');

define('_HE_CHESS_NOTATION_020', '
The notation for a move is composed of four parts (and an optional fifth part for pawn promotion):
');
define('_HE_CHESS_NOTATION_020_1',   'Piece');
define('_HE_CHESS_NOTATION_020_1_A',   'K (King)');
define('_HE_CHESS_NOTATION_020_1_B',   'Q (Queen)');
define('_HE_CHESS_NOTATION_020_1_C',   'R (Rook)');
define('_HE_CHESS_NOTATION_020_1_D',   'B (Bishop)');
define('_HE_CHESS_NOTATION_020_1_E',   'N (Knight)');
define('_HE_CHESS_NOTATION_020_1_F',   'P (Pawn)');
define('_HE_CHESS_NOTATION_020_2',   'Initial tile');
define('_HE_CHESS_NOTATION_020_2_A',   'Examples: e4, f2, h8');
define('_HE_CHESS_NOTATION_020_3',   'Action');
define('_HE_CHESS_NOTATION_020_3_A',   '- (move)');
define('_HE_CHESS_NOTATION_020_3_B',   'x (capture)');
define('_HE_CHESS_NOTATION_020_4',   'Destination tile');
define('_HE_CHESS_NOTATION_020_4_A',   'Examples: a8, c6, g5');
define('_HE_CHESS_NOTATION_020_5',   'Pawn promotion (when applicable)');
define('_HE_CHESS_NOTATION_020_5_A',   'Possible values: =Q, =R, =B, =N');

define('_HE_CHESS_NOTATION_030', '
Examples of complete moves:
');
define('_HE_CHESS_NOTATION_030_1', 'Pe2-e4  (pawn moves from e2 to e4)');
define('_HE_CHESS_NOTATION_030_2', 'Pf4xe5  (pawn at f4 captures piece at e5)');
define('_HE_CHESS_NOTATION_030_3', 'Nf3xe5  (knight at f3 captures piece at e5)');
define('_HE_CHESS_NOTATION_030_4', 'Qd8-h4  (queen moves from d8 to h4)');
define('_HE_CHESS_NOTATION_030_5', 'Ke1-g1  (white castles king-side)');
define('_HE_CHESS_NOTATION_030_6', 'Ke8-c8  (black castles queen-side)');
define('_HE_CHESS_NOTATION_030_7', 'Pe7-e8=Q  (pawn moves from e7 to e8 and is promoted to queen)');

define('_HE_CHESS_NOTATION_040', '
Instead of the above notation, you may use Standard Algebraic Notation (SAN). Examples:
');
define('_HE_CHESS_NOTATION_040_1', 'e4  (pawn moves to e4)');
define('_HE_CHESS_NOTATION_040_2', 'fxe5  (pawn on f-file captures piece at e5)');
define('_HE_CHESS_NOTATION_040_3', 'Nxe5  (knight captures piece at e5)');
define('_HE_CHESS_NOTATION_040_4', 'Qh4  (queen moves to h4)');
define('_HE_CHESS_NOTATION_040_5', 'O-O  (castles king-side)');
define('_HE_CHESS_NOTATION_040_6', 'O-O-O  (castles queen-side)');
define('_HE_CHESS_NOTATION_040_7', 'e8Q  (pawn moves to e8 and is promoted to queen)');

define('_HE_CHESS_NOTATION_050', '
The notation for castling uses the uppercase letter "O" (oh), not the digit "0" (zero).
');

define('_HE_CHESS_NOTATION_060', '
SAN is described in more detail at the <a href="#fide">FIDE</a> site.
');

define('_HE_CHESS_NOTATION_070', '
<em>The piece identifier must be upper case, and the file coordinate must be lower case.
Only valid, non-ambiguous moves will be accepted.</em>
');

// --------------------

define('_HE_CHESS_EXPORT_TITLE', 'Exporting games');

define('_HE_CHESS_EXPORT_010', '
The current state of the game is displayed in both Portable Game Notation (PGN) and Forsyth-Edwards Notation (FEN).
These are widely used notations for representing chess games.
You may save the PGN or FEN representation of the game for your own records,
or to import the game into other chess software.
');

// --------------------

define('_HE_CHESS_MISC_TITLE', 'Miscellaneous');

define('_HE_CHESS_MISC_010', '
The stalemate test does not recognize whether a piece, other than the king,
is bound by check (unable to move because it would place the king in check).
So although the player won\'t be able to make any moves, the situation will not be detected as stalemate.
You can work around this by offering a draw, claiming a draw (if applicable), or requesting arbitration.
Here\'s an example of a board position in which the player to move (black) has no legal move,
but the stalemate is not detected by the software:
');
define('_HE_CHESS_MISC_010_IMAGE', 'stalemate example');

define('_HE_CHESS_MISC_020', '
Article 9.6 of the FIDE Laws of Chess states that
<em>The game is drawn when a position is reached from which a checkmate cannot occur by any possible series of legal moves,
even with the most unskilled play. This immediately ends the game.</em>
This rule is not fully enforced since I don\'t know how to implement it.
The three situations King vs. King, King vs. King + Bishop, and King vs. King + Knight will cause the game to immediately end in a draw.
More complicated scenarios are not handled automatically, and must be dealt with by offering a draw,
claiming a draw (if applicable), or requesting arbitration.
');

define('_HE_CHESS_MISC_030', '
There are no time constraints on play.
None of the FIDE rules concerning clocks, time limits or flags are applicable here.
');

// --------------------

define('_HE_CHESS_ADMIN_TITLE', 'Administration and arbitration');

define('_HE_CHESS_ADMIN_010', '
An <em>arbiter</em> is a user with module admin rights for the chess module.
');

define('_HE_CHESS_ADMIN_020', '
From the Xoops control panel, an arbiter may view or edit the chess module preferences, and may arbitrate games and challenges.
');

define('_HE_CHESS_ADMIN_030', '
When an arbiter accesses a challenge from the control panel, he has the option of deleting that challenge.
');

define('_HE_CHESS_ADMIN_040', '
When an arbiter accesses an active or suspended game from the control panel,
he will see the normal game page, with the addition of <em>arbiter controls</em>.
If a game is active, the arbiter controls allow the arbiter to suspend the game.
If a game is suspended, the arbiter controls allow the arbiter to resume normal play, declare a draw, or delete the game.
The arbiter may also remove the arbiter controls, so that the game page reverts to a normal user\'s view.
The arbiter controls will be restored upon re-accessing the game from the control panel.
');

define('_HE_CHESS_ADMIN_050', '
An arbiter may subscribe to be notified when a player requests arbitration in a chess game.
');


// --------------------

/**#@-*/

?>