<{*** #*#DEBUG#
<{php}>
global $xoopsTpl;
var_dump('chess_games', $xoopsTpl->get_template_vars('chess_games'));
<{/php}>
***}>

<{*<{assign var=chess_challenges value=0}>*}> <{* #*#DEBUG# *}>
<{*<{assign var=chess_games value=0}>*}> <{* #*#DEBUG# *}>

<a name="challenges"></a>

<table class="outer">
		<tr class="outer">
			<th class="outer" colspan="4"><{$smarty.const._MD_CHESS_LABEL_CHALLENGES}></th>
		</tr>

<{if !empty($chess_challenges)}>

		<tr class="head">
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_TYPE}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_CHALLENGER}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_CREATED}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_COLOR_OPTION}></td>
		</tr>

		<{foreach from=$chess_challenges item=challenge}>
			<{cycle values="odd,even" assign=class}>
			<{if $challenge.game_type eq $smarty.const._CHESS_GAMETYPE_OPEN}>
				<{assign var=gametype value=$smarty.const._MD_CHESS_LABEL_GAMETYPE_OPEN}>
			<{elseif $challenge.game_type eq $smarty.const._CHESS_GAMETYPE_USER}>
				<{assign var=gametype value=$smarty.const._MD_CHESS_LABEL_GAMETYPE_USER|cat:': '|cat:$challenge.username_player2}>
			<{else}>
				<{assign var=gametype value='<div class="errorMsg">'|cat:$smarty.const._MD_CHESS_LABEL_ERROR|cat:'</div>'}>
			<{/if}>
			<tr class="<{$class}>">
				<td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/create.php?challenge_id=<{$challenge.challenge_id}>"><{$gametype}></a></td>
				<td class="<{$class}>"><{$challenge.username_player1}></td>
				<td class="<{$class}>"><{$challenge.create_date|xoops_format_date:$chess_date_format}></td>
				<td class="<{$class}>"><{$challenge.color_option}></td>
			</tr>
		<{/foreach}>

<{else}>

		<tr class="odd">
			<td class="odd" colspan="4"><{$smarty.const._MD_CHESS_LABEL_NO_CHALLENGES}></td>
		</tr>

<{/if}>

</table>

<br />

<a name="games"></a>

<table class="outer">
		<tr class="outer">
			<th class="outer" colspan="5"><{$smarty.const._MD_CHESS_LABEL_GAMES}></th>
		</tr>

<{if !empty($chess_games)}>

		<tr class="head">
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_GAME}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_CREATED}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_STARTED}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_LAST_MOVE}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_STATUS}></td>
		</tr>

		<{foreach from=$chess_games item=game}>
			<{cycle values="odd,even" assign=class}>
			<tr class="<{$class}>">
				<td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/game.php?game_id=<{$game.game_id}>"><{$game.username_white}> <{$smarty.const._MD_CHESS_LABEL_VS}> <{$game.username_black}></a></td>
				<td class="<{$class}>"><{$game.create_date|xoops_format_date:$chess_date_format}></td>
				<td class="<{$class}>"><{if $game.start_date}><{$game.start_date|xoops_format_date:$chess_date_format}><{else}>&nbsp;<{/if}></td>
				<td class="<{$class}>"><{if $game.last_date}><{$game.last_date|xoops_format_date:$chess_date_format}><{else}>&nbsp;<{/if}></td>
				<td class="<{$class}>">
					<{if $game.pgn_result eq '1/2-1/2'}>
						<{$smarty.const._MD_CHESS_LABEL_DRAW}>
					<{elseif $game.pgn_result eq '1-0'}>
						<{$smarty.const._MD_CHESS_LABEL_WHITE_WON}>
					<{elseif $game.pgn_result eq '0-1'}>
						<{$smarty.const._MD_CHESS_LABEL_BLACK_WON}>
					<{elseif $game.pgn_result eq '*'}>
						<{if $game.fen_active_color eq 'w'}>
							<{$smarty.const._MD_CHESS_LABEL_WHITE_TO_MOVE}>
						<{else}>
							<{$smarty.const._MD_CHESS_LABEL_BLACK_TO_MOVE}>
						<{/if}>
					<{else}>
						<div class="errorMsg"><{$chess.const._MD_CHESS_LABEL_ERROR}></div>
					<{/if}>
				</td>
			</tr>
		<{/foreach}>

<{else}>

		<tr class="odd">
			<td class="odd" colspan="5"><{$smarty.const._MD_CHESS_LABEL_NO_GAMES}></td>
		</tr>

<{/if}>

</table>

<{* Notifications *}>
<{include file='db:system_notification_select.html'}>
