<script type="text/javascript" language="javascript">
function confirmArbiterAction()
{
	<{* determine which radio button is selected *}>
	for (i = 0; i < window.document.arbitrateform.arbiter_action.length; ++i) {
		if (window.document.arbitrateform.arbiter_action[i].checked) {
			value = window.document.arbitrateform.arbiter_action[i].value;
			break;
		}
	}

	<{* determine confirm-text to display based on which radio button is selected *}>
	switch (value) {
		case '<{$smarty.const._CHESS_ARBITER_RESUME}>':
			text = '<{$smarty.const._MD_CHESS_ARBITER_RESUME}>'  + '?';
			ask  = true;
			break;
		case '<{$smarty.const._CHESS_ARBITER_DRAW}>':
			text = '<{$smarty.const._MD_CHESS_ARBITER_DRAW}>'    + '?';
			ask  = true;
			break;
		case '<{$smarty.const._CHESS_ARBITER_DELETE}>':
			text = '<{$smarty.const._MD_CHESS_ARBITER_DELETE}>'  + '?  ' + '<{$smarty.const._MD_CHESS_ARBITER_DELETE_WARNING}>';
			ask  = true;
			break;
		case '<{$smarty.const._CHESS_ARBITER_SUSPEND}>':
			text = '<{$smarty.const._MD_CHESS_ARBITER_SUSPEND}>' + '?';
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
</script>

<form name="arbitrateform" method='post' action='game.php?game_id=<{$chess_gamedata.game_id}>'>
<table border='1'>
<tr>
	<td class="head" style="text-align:center" colspan="2">
		<{$smarty.const._MD_CHESS_ARBITER_CONTROLS}>
	</td>
</tr>

<{if $chess_gamedata.suspended}>

	<tr>
		<td class="odd" style="text-align:left" colspan="2">
			Suspension information:
			<{$chess_gamedata.suspended}> <{* date|player_uid|type|explanation - #*#TBD# - display this more nicely *}>
		</td>
	</tr>

	<{if $chess_gamedata.pgn_result eq '*'}>
		<tr>
			<td class="odd" style="text-align:left" colspan="2">
				<input type='radio' name='arbiter_action' value='<{$smarty.const._CHESS_ARBITER_RESUME}>' />
				<{$smarty.const._MD_CHESS_ARBITER_RESUME}>
			</td>
		</tr>
		<tr>
			<td class="odd" style="text-align:left">
				<input type='radio' name='arbiter_action' value='<{$smarty.const._CHESS_ARBITER_DRAW}>' />
				<{$smarty.const._MD_CHESS_ARBITER_DRAW}>
			</td>
			<td class="odd" style="text-align:center">
				<input type="text" name='arbiter_explain' size="30" maxlength="<{$smarty.const._CHESS_TEXTBOX_EXPLAIN_MAXLEN}>" value="<{$smarty.const._MD_CHESS_ARBITER_EXPLAIN}>" />
			</td>
		</tr>
	<{/if}>

	<tr>
		<td class="odd" style="text-align:left" colspan="2">
			<input type='radio' name='arbiter_action'    value='<{$smarty.const._CHESS_ARBITER_DELETE}>' />
			<{$smarty.const._MD_CHESS_ARBITER_DELETE}>
		</td>
	</tr>

<{else}>

	<{if $chess_gamedata.pgn_result eq '*'}>
		<tr>
			<td class="odd" style="text-align:left">
				<input type='radio' name='arbiter_action' value='<{$smarty.const._CHESS_ARBITER_SUSPEND}>' />
				<{$smarty.const._MD_CHESS_ARBITER_SUSPEND}>
			</td>
			<td class="odd" style="text-align:center">
				<input type="text" name='arbiter_explain' size="30" maxlength="<{$smarty.const._CHESS_TEXTBOX_EXPLAIN_MAXLEN}>" value="<{$smarty.const._MD_CHESS_ARBITER_EXPLAIN}>" />
			</td>
		</tr>
	<{/if}>

<{/if}>

<tr>
	<td class="odd" style="text-align:left" colspan="2">
		<input type='radio' name='arbiter_action'       value='<{$smarty.const._CHESS_ARBITER_NOACTION}>' checked="checked" />
		<{$smarty.const._MD_CHESS_ARBITER_NOACTION}>
	</td>
</tr>

<tr>
	<td class="odd" style="text-align:center" colspan="2">
		<input type='submit' name='submit_arbitrate'    value='<{$smarty.const._MD_CHESS_BUTTON_ARBITRATE}>' onClick="return confirmArbiterAction();" />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='checkbox' name='show_arbiter_ctrl' value='1' checked="checked" />
		<{$smarty.const._MD_CHESS_ARBITER_SHOWCTRL}>
	</td>
</tr>

</table>
</form>
