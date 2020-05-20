<form name="prefsform" method='post' action='game.php?game_id=<{$chess_gamedata.game_id}>'>
<table>
<tr>
	<td class="head" style="text-align:center">
		<{$smarty.const._MD_CHESS_BOARD_DISPLAY}>
	</td>
</tr>
<tr>
	<td class="odd" style="text-align:left">
		<input type='radio' name='orientation' value='<{$smarty.const._CHESS_ORIENTATION_ACTIVE}>' <{if !isset($chess_orientation) or $chess_orientation eq $smarty.const._CHESS_ORIENTATION_ACTIVE}>checked="checked"<{/if}> />
		<{$smarty.const._MD_CHESS_ORIENTATION_ACTIVE}>
	</td>
</tr>
<tr>
	<td class="odd" style="text-align:left">
		<input type='radio' name='orientation' value='<{$smarty.const._CHESS_ORIENTATION_WHITE}>' <{if $chess_orientation eq $smarty.const._CHESS_ORIENTATION_WHITE}>checked="checked"<{/if}> />
		<{$smarty.const._MD_CHESS_ORIENTATION_WHITE}>
	</td>
</tr>
<tr>
	<td class="odd" style="text-align:left">
		<input type='radio' name='orientation' value='<{$smarty.const._CHESS_ORIENTATION_BLACK}>' <{if $chess_orientation eq $smarty.const._CHESS_ORIENTATION_BLACK}>checked="checked"<{/if}> />
		<{$smarty.const._MD_CHESS_ORIENTATION_BLACK}>
	</td>
</tr>
<tr>
	<td class="odd" style="text-align:center">
		<input type='submit' name='submit_refresh' value='<{$smarty.const._MD_CHESS_BUTTON_REFRESH}>' />
	</td>
</tr>

</table>
</form>
