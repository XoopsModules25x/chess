<{* #*#DEBUG# *}>
<{***
<table width="%25">
<tr><td>Page generated:</td><td><{$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}></td></tr>
<tr><td>Current time:</td><td><{insert name="chess_show_date"}></td></tr>
</table>
***}>

<script type="text/javascript" language="javascript">

<{if $chess_user_color}>
	function confirmAction()
	{
		<{* no action unless the confirm-checkbox is selected *}>
		if (!window.document.cmdform.confirm.checked) {
			return true;
		}

		<{* determine which radio button is selected *}>
		for (i = 0; i < window.document.cmdform.movetype.length; ++i) {
			if (window.document.cmdform.movetype[i].checked) {
				value = window.document.cmdform.movetype[i].value;
				break;
			}
		}

		<{* determine confirm-text to display based on which radio button is selected *}>
		switch (value) {
			case '<{$smarty.const._CHESS_MOVETYPE_NORMAL}>':
				text = window.document.cmdform.chessmove.value + '?';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_CLAIM_DRAW_50}>':
				if (window.document.cmdform.chessmove.value) {
					extra_text = ' <{$smarty.const._MD_CHESS_AFTER_MOVE}> ' + window.document.cmdform.chessmove.value;
				} else {
					extra_text = '';
				}
				text = '<{$smarty.const._MD_CHESS_CLAIM_DRAW_50}>' + extra_text + '?';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_CLAIM_DRAW_3}>':
				if (window.document.cmdform.chessmove.value) {
					extra_text = ' <{$smarty.const._MD_CHESS_AFTER_MOVE}> ' + window.document.cmdform.chessmove.value;
				} else {
					extra_text = '';
				}
				text = '<{$smarty.const._MD_CHESS_CLAIM_DRAW_3}>' + extra_text + '?';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_RESIGN}>':
				text = '<{$smarty.const._MD_CHESS_RESIGN}>' + '?';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_OFFER_DRAW}>':
				text = '<{$smarty.const._MD_CHESS_OFFER_DRAW}>' + '?';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_ACCEPT_DRAW}>':
				text = '<{$smarty.const._MD_CHESS_ACCEPT_DRAW}>' + '?';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_REJECT_DRAW}>':
				text = '<{$smarty.const._MD_CHESS_REJECT_DRAW}>' + '?';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_RESTART}>':
				text = '<{$smarty.const._MD_CHESS_RESTART}>' + '?';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_DELETE}>':
				text = '<{$smarty.const._MD_CHESS_DELETE}>'  + '?  ' + '<{$smarty.const._MD_CHESS_DELETE_WARNING}>';
				ask  = true;
				break;
			case '<{$smarty.const._CHESS_MOVETYPE_WANT_ARBITRATION}>':
				text = '<{$smarty.const._MD_CHESS_WANT_ARBITRATION}>' + '?';
				ask  = true;
				break;
			default:
				text = '';
				ask  = false;
				break;
		}

		<{* if an action requiring confirmation was selected, display the confirm-dialog *}>
		if (ask) {
			return window.confirm(text);
		} else {
			return true;
		}
	}
<{/if}>

</script>

<{* selfplay - it's a self-play game *}>
<{if $chess_gamedata.white_uid eq $chess_gamedata.black_uid}>
	<{assign var=selfplay value=true}>
<{else}>
	<{assign var=selfplay value=false}>
<{/if}>

<{* can_move - the game isn't over or suspended, it's the current user's move, and he hasn't offered a draw that has been neither accepted nor rejected *}>
<{if $chess_gamedata.pgn_result eq '*' and not $chess_gamedata.suspended and $chess_user_color eq $chess_gamedata.fen_active_color and $chess_gamedata.offer_draw ne $chess_user_color}>
	<{assign var=can_move value=true}>
<{else}>
	<{assign var=can_move value=false}>
<{/if}>

<table>

<tr>
	<td style="text-align:center">

		<table>
		<tr>
			<th class="head" style="text-align:center" colspan="2"><b><font size="+1"><{$chess_white_user|replace:' ':'&nbsp;'}></font></b>&nbsp;<{$smarty.const._MD_CHESS_LABEL_VS}>&nbsp;<b><font size="+1"><{$chess_black_user|replace:' ':'&nbsp;'}></font></b></th>
		</tr>

		<{* Display first and last move dates if defined, otherwise display game creation date. *}>
		<{assign var=chess_date_format_nbsp value=$chess_date_format|replace:' ':'\&\n\b\s\p\;'}>
		<{if $chess_start_date and $chess_last_date}>
			<tr>
				<td class="odd" style="text-align:left"><{$smarty.const._MD_CHESS_GAME_STARTED|replace:' ':'&nbsp;'}>:</td>
				<td class="odd" style="text-align:right"><{$chess_start_date|xoops_format_date:$chess_date_format_nbsp}></td>
			</tr>
			<tr>
				<td class="odd" style="text-align:left"><{$smarty.const._MD_CHESS_LABEL_LAST_MOVE|replace:' ':'&nbsp;'}>:</td>
				<td class="odd" style="text-align:right"><{$chess_last_date|xoops_format_date:$chess_date_format_nbsp}></td>
			</tr>
		<{else}>
			<tr>
				<td class="odd" style="text-align:left"><{$smarty.const._MD_CHESS_GAME_CREATED|replace:' ':'&nbsp;'}>:</td>
				<td class="odd" style="text-align:right"><{$chess_create_date|xoops_format_date:$chess_date_format_nbsp}></td>
			</tr>
		<{/if}>

		<{* If game is suspended, indicate it. *}>
		<{if $chess_gamedata.suspended}>

			<tr>
				<td class="head" style="text-align:center" colspan="2">
					<{if $chess_gamedata.fen_active_color eq 'w'}>
						<{$smarty.const._MD_CHESS_LABEL_WHITE}> (<{$chess_white_user|replace:' ':'&nbsp;'}>) <{$smarty.const._MD_CHESS_LABEL_TO_MOVE}>
					<{else}>
						<{$smarty.const._MD_CHESS_LABEL_BLACK}> (<{$chess_black_user|replace:' ':'&nbsp;'}>) <{$smarty.const._MD_CHESS_LABEL_TO_MOVE}>
					<{/if}>
				</td>
			</tr>
			<tr>
				<td class="head" style="text-align:center" colspan="2">
					<{$smarty.const._MD_CHESS_LABEL_GAME_SUSPENDED}>
				</td>
			</tr>

		<{* If game is over, display result. *}>
		<{elseif $chess_gamedata.pgn_result ne '*'}>

			<tr>
				<td class="head" style="text-align:center" colspan="2"><{$smarty.const._MD_CHESS_LABEL_GAME_OVER}>: <{$chess_gamedata.pgn_result}></td>
			</tr>

			<{* Display game result comment, if present. *}>
			<{if !empty($chess_result_comment)}>
				<tr>
					<td class="head" style="text-align:center" colspan="2"><{$chess_result_comment}></td>
				</tr>
			<{/if}>

		<{* Otherwise game is in progress, so display move-form. *}>
		<{else}>

				<tr>
					<td colspan="2"><{include file="db:chess_game_moveform.html"}></td>
				</tr>

		<{/if}>

		</table>

		<{if !empty($chess_movelist)}>

			<br />
			<table>
			<tr>
				<td class="head" style="text-align:center" colspan="3"><{$smarty.const._MD_CHESS_MOVE_LIST}></td>
			</tr>
			<{foreach from=$chess_movelist item=move}>
				<{cycle values="odd,even" assign=class}>
				<tr>
					<td class="<{$class}>" style="text-align:right"><{if $move[0]}><{$move[0]}><{else}>&nbsp;<{/if}>&nbsp;</td> <{* move number  *}>
					<td class="<{$class}>" style="text-align:left"> <{if $move[1]}><{$move[1]}><{else}>&nbsp;<{/if}></td>       <{* white's move *}>
					<td class="<{$class}>" style="text-align:left"> <{if $move[2]}><{$move[2]}><{else}>&nbsp;<{/if}></td>       <{* black's move *}>
				</tr>
			<{/foreach}>
			</table>
		<{/if}>

		<br />

		<table>
		<tr>
			<td class="head" style="text-align:center"><{$smarty.const._MD_CHESS_EXPORT_FORMATS}></td>
		</tr>
		<tr>
			<td class="odd">
				<b><{$smarty.const._MD_CHESS_PGN_FULL}> (<{$smarty.const._MD_CHESS_PGN_ABBREV}>)</b><br />
				<{* textarea tag not part of a form, only used for display purposes, and to allow easy copying *}>
				<textarea name="pgn_display" rows="3" cols="40"><{$chess_pgn_string}></textarea>
			</td>
		</tr>
		<tr>
			<td class="odd">
				<b><{$smarty.const._MD_CHESS_FEN_FULL}> (<{$smarty.const._MD_CHESS_FEN_ABBREV}>)</b><br />
				<{* textarea tag not part of a form, only used for display purposes, and to allow easy copying *}>
				<{strip}>
				<textarea name="fen_display" rows="1" cols="40">
					<{$chess_gamedata.fen_piece_placement}>&nbsp;
					<{$chess_gamedata.fen_active_color}>&nbsp;
					<{$chess_gamedata.fen_castling_availability}>&nbsp;
					<{$chess_gamedata.fen_en_passant_target_square}>&nbsp;
					<{$chess_gamedata.fen_halfmove_clock}>&nbsp;
					<{$chess_gamedata.fen_fullmove_number}>
				</textarea>
				<{/strip}>
			</td>
		</tr>
		</table>

	</td>

	<td style="text-align:center">

		<{include file="db:chess_game_board.html"}>

		<{if $can_move}>

			<noscript>
				<br />

				<table>
				<tr>
					<td><div class="errorMsg">Javascript not enabled. Moves must be made by text entry.</div></td>
				</tr>
				</table>
			</noscript>

		<{/if}>

		<{* display captured pieces *}>
		<{if !empty($chess_captured_pieces.white) or !empty($chess_captured_pieces.black)}>

			<br />

			<table border="0">
			<tr>
				<td class="head" style="text-align:center">
					<{$smarty.const._MD_CHESS_CAPTURED_PIECES}>
				</td>
			</tr>
			<{foreach from=$chess_captured_pieces item=captured_pieces_color}>
				<tr>
					<td class="odd" style="text-align:left">
						<{foreach from=$captured_pieces_color item=piece}>
							<img border="0" width="20" height="21" alt="<{$chess_pieces[$piece].alt}>" src="images/wcg/s<{$chess_pieces[$piece].name}>.gif" />
						<{/foreach}>
					</td>
					<{if empty($captured_pieces_color)}>
						<td class="odd">&nbsp;</td>
					<{/if}>
				</tr>
			<{/foreach}>
			</table>

		<{/if}>

		<br />

		<{include file="db:chess_game_prefsform.html"}>

		<{if $chess_show_arbitration_controls}>

			<br />
			<{include file="db:chess_game_arbitrateform.html"}>

		<{/if}>

	</td>
</tr>
</table>

<{* #*#DEBUG# *}>
<{***
<br />
Debug info:<br />
<{foreach from=$chess_gamedata key=key item=value}>
gamedata['<{$key}>']='<{$value}>'<br />
<{/foreach}>
***}>

<{* Comments *}>

<div style="text-align: center; padding: 3px; margin: 3px;">
	<{$commentsnav}>
	<{$lang_notice}>
</div>

<div style="margin: 3px; padding: 3px;">
<!-- start comments loop -->
<{if $comment_mode == "flat"}>
	<{include file="db:system_comments_flat.html"}>
<{elseif $comment_mode == "thread"}>
	<{include file="db:system_comments_thread.html"}>
<{elseif $comment_mode == "nest"}>
	<{include file="db:system_comments_nest.html"}>
<{/if}>
<!-- end comments loop -->
</div>

<{* Notifications *}>
<{include file='db:system_notification_select.html'}>

<{* preload images *}>

<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wking.gif"     />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wqueen.gif"    />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wrook.gif"     />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wbishop.gif"   />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wknight.gif"   />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wpawn.gif"     />

<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bking.gif"     />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bqueen.gif"    />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/brook.gif"     />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bbishop.gif"   />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bknight.gif"   />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bpawn.gif"     />

<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/w_square.jpg"  />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/b_square.jpg"  />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/empty.gif"     />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/spacer.gif"        />

<{if $can_move}>
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wking_h.gif"   />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wqueen_h.gif"  />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wrook_h.gif"   />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wbishop_h.gif" />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wknight_h.gif" />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/wpawn_h.gif"   />

<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bking_h.gif"   />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bqueen_h.gif"  />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/brook_h.gif"   />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bbishop_h.gif" />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bknight_h.gif" />
<img class="chessHiddenPic" height="1" width="1" alt="-" src="images/wcg/bpawn_h.gif"   />
<{/if}>
