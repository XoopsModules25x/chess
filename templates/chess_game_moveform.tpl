<form name="cmdform" method='post' action='game.php?game_id=<{$chess_gamedata.game_id}>'>

<input type='hidden' name='orientation' value='<{$chess_orientation}>' />

<table>

<tr>
	<td class="head" style="text-align:center">
		<{if $chess_gamedata.fen_active_color eq 'w'}>
			<{$smarty.const._MD_CHESS_LABEL_WHITE}> (<{$chess_white_user|replace:' ':'&nbsp;'}>) <{$smarty.const._MD_CHESS_LABEL_TO_MOVE}>
		<{else}>
			<{$smarty.const._MD_CHESS_LABEL_BLACK}> (<{$chess_black_user|replace:' ':'&nbsp;'}>) <{$smarty.const._MD_CHESS_LABEL_TO_MOVE}>
		<{/if}>
	</td>
</tr>

<{if !empty($chess_gamedata.offer_draw)}>
	<tr>
		<td class="head" style="text-align:center">
			<{if $chess_gamedata.offer_draw eq 'w'}>
				<{$smarty.const._MD_CHESS_WHITE_OFFERED_DRAW}>
			<{else}>
				<{$smarty.const._MD_CHESS_BLACK_OFFERED_DRAW}>
			<{/if}>
		</td>
	</tr>
<{/if}>

</table>

<{if $chess_move_result}>

	<br />

	<table>
	<tr>
		<td><div class="<{if $chess_move_performed}>resultMsg<{else}>errorMsg<{/if}>"><{$chess_move_result}></div></td>
	</tr>
	</table>

<{/if}>

<{if $chess_draw_claim_error_text}>

	<br />

	<table>
	<tr>
		<td><div class="errorMsg"><{$chess_draw_claim_error_text}></div></td>
	</tr>
	</table>

<{/if}>

<{* if user is a player, provide player controls *}>
<{if $chess_user_color}>
	<br />

	<table>
		<tr>
			<td class="head" style="text-align:center" colspan="2"><{$smarty.const._MD_CHESS_MOVE_ENTRY}></td>
		</tr>
<{/if}>

<{* provide move-entry field only if the current user can move *}>
<{if $can_move}>
	<{if $chess_gamedata.start_date}>
		<tr>
			<td class="odd" style="text-align:left">
				<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_NORMAL}>' checked='checked' />
				<{$smarty.const._MD_CHESS_NORMAL_MOVE}>
			</td>
			<td class="odd" style="text-align:center; vertical-align: middle;" rowspan="3">
				<input type='text' name='chessmove' maxlength='8' size='10' />
			</td>
		</tr>
		<tr>
			<td class="odd" style="text-align:left">
				<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_CLAIM_DRAW_50}>' />
				<{$smarty.const._MD_CHESS_CLAIM_DRAW_50}>
			</td>
		</tr>
		<tr>
			<td class="odd" style="text-align:left">
				<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_CLAIM_DRAW_3}>' />
				<{$smarty.const._MD_CHESS_CLAIM_DRAW_3}>
			</td>
		</tr>
	<{/if}>
<{/if}>

<{* if user is a player, provide player controls *}>
<{if $chess_user_color}>
	<tr>
		<td class="odd" style="text-align:left" colspan="2">
			<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_RESIGN}>' />
			<{$smarty.const._MD_CHESS_RESIGN}>
		</td>
	</tr>

	<{* if no draw offer pending, provide offer-draw button *}>
	<{if not $selfplay and empty($chess_gamedata.offer_draw)}>

		<tr>
			<td class="odd" style="text-align:left" colspan="2">
				<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_OFFER_DRAW}>' />
				<{$smarty.const._MD_CHESS_OFFER_DRAW}>
			</td>
		</tr>

	<{* if opponent offered draw, provide accept-draw and reject-draw buttons *}>
	<{elseif not $selfplay and !empty($chess_gamedata.offer_draw) and $chess_gamedata.offer_draw ne $chess_user_color}>

		<tr>
			<td class="odd" style="text-align:left" colspan="2">
				<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_ACCEPT_DRAW}>' />
				<{$smarty.const._MD_CHESS_ACCEPT_DRAW}>
			</td>
		</tr>

		<tr>
			<td class="odd" style="text-align:left" colspan="2">
				<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_REJECT_DRAW}>' />
				<{$smarty.const._MD_CHESS_REJECT_DRAW}>
			</td>
		</tr>

	<{/if}>

	<{* if self-play, provide restart button *}>
	<{if $selfplay}>
		<tr>
			<td class="odd" style="text-align:left" colspan="2">
				<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_RESTART}>' />
				<{$smarty.const._MD_CHESS_RESTART}>
			</td>
		</tr>
	<{/if}>

	<{* if self-play, or if deletion of games is allowed, provide delete button *}>
	<{if $selfplay or $chess_allow_delete}>
		<tr>
			<td class="odd" style="text-align:left" colspan="2">
				<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_DELETE}>' />
				<{$smarty.const._MD_CHESS_DELETE}>
			</td>
		</tr>
	<{/if}>

	<tr>
	</tr>
	<tr>
		<td class="odd" style="text-align:left">
			<input type='radio' name='movetype' value='<{$smarty.const._CHESS_MOVETYPE_WANT_ARBITRATION}>' />
			<{$smarty.const._MD_CHESS_WANT_ARBITRATION}>
		</td>
		<td class="odd" style="text-align:center">
			<input type="text" name='move_explain' size="30" maxlength="<{$smarty.const._CHESS_TEXTBOX_EXPLAIN_MAXLEN}>" value="<{$smarty.const._MD_CHESS_MOVE_EXPLAIN}>" />
		</td>
	</tr>

	<tr>
		<td class="odd" style="text-align:center" colspan="2">

		<input type='submit' name='submit_move' value='<{$smarty.const._MD_CHESS_BUTTON_MOVE}>' onClick="return confirmAction();" />

		<{* The confirm checkbox is only applicable if Javascript is enabled. *}>
		<script type="text/javascript">
			window.document.write('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
			window.document.write('<input type="checkbox" name="confirm" value="1" <{if $chess_confirm}>checked="checked"<{/if}> />');
			window.document.write('<{$smarty.const._MD_CHESS_CONFIRM}>');
		</script>

		</td>
	</tr>

<{/if}>

<{* if user is a player, provide player controls *}>
<{if $chess_user_color}>
	</table>
<{/if}>


</form>
