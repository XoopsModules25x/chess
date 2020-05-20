<form name='prefsform' method='post' action='game.php?game_id=<{$chess_gamedata.game_id}>'>

<table class='outer'>
<tr>
	<td class='head'>

		<select size='1' name='orientation' id='orientation'>

			<option value='<{$smarty.const._CHESS_ORIENTATION_ACTIVE}>'
				<{if $chess_orientation eq $smarty.const._CHESS_ORIENTATION_ACTIVE}>selected='selected'<{/if}>
			>
			<{$smarty.const._MD_CHESS_ORIENTATION_ACTIVE}>
			</option>

			<option value='<{$smarty.const._CHESS_ORIENTATION_WHITE}>'
				<{if $chess_orientation eq $smarty.const._CHESS_ORIENTATION_WHITE}>selected='selected'<{/if}>
			>
			<{$smarty.const._MD_CHESS_ORIENTATION_WHITE}>
			</option>

			<option value='<{$smarty.const._CHESS_ORIENTATION_BLACK}>'
				<{if $chess_orientation eq $smarty.const._CHESS_ORIENTATION_BLACK}>selected='selected'<{/if}>
			>
			<{$smarty.const._MD_CHESS_ORIENTATION_BLACK}>
			</option>

		</select>

		&nbsp;&nbsp;&nbsp;&nbsp;

		<input type='submit' class='formButton' name='submit_refresh' value='<{$smarty.const._MD_CHESS_BUTTON_REFRESH}>'>
	</td>
</tr>
</table>

<{* security token *}>
<{$chess_xoops_request_token}>

</form>
