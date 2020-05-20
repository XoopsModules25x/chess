<a name="challenges"></a>

<form name='<{$form1.name}>' id='<{$form1.name}>' action='<{$form1.action}>' method='<{$form1.method}>' <{$form1.extra}>>

<table class="outer">
		<tr class="outer">
			<th class="outer" colspan="<{if $chess_rating_system != 'none'}>5<{else}>4<{/if}>">
				<{$smarty.const._MD_CHESS_LABEL_CHALLENGES}>
				&nbsp;&nbsp;
				<{$form1.elements.cshow.body}>
				&nbsp;&nbsp;
				<{$form1.elements.gstart.body}>
				<{$form1.elements.gshow1.body}>
				<{$form1.elements.gshow2.body}>
				<{$form1.elements.submit.body}>
			</th>
		</tr>

<{if !empty($chess_challenges)}>

		<tr class="head">
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_TYPE}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_CHALLENGER}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_CREATED}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LABEL_COLOR_OPTION}></td>
			<{if $chess_rating_system != 'none'}>
				<td class="head"><{$smarty.const._MD_CHESS_RATED_GAME}></td>
			<{/if}>
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
				<td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/player_stats.php?player_uid=<{$challenge.player1_uid}>"><{$challenge.username_player1}></a></td>
				<td class="<{$class}>"><{$chess_date_format|date:$challenge.create_date}></td>
				<td class="<{$class}>"><{$challenge.color_option}></td>
				<{if $chess_rating_system != 'none'}>
					<td class="<{$class}>"><{if $challenge.is_rated}><{$smarty.const._YES}><{else}><{$smarty.const._NO}><{/if}></td>
				<{/if}>
			</tr>
		<{/foreach}>

<{else}>

		<tr class="odd">
			<td class="odd" colspan="<{if $chess_rating_system != 'none'}>5<{else}>4<{/if}>"><{$smarty.const._MD_CHESS_LABEL_NO_CHALLENGES}></td>
		</tr>

<{/if}>

</table>

</form>

<div class="head" align="center"><{$chess_challenges_pagenav}>&nbsp;</div>

<br>

<a name="games"></a>

<form name='<{$form2.name}>' id='<{$form2.name}>' action='<{$form2.action}>' method='<{$form2.method}>' <{$form2.extra}>>

<table class="outer">
		<tr class="outer">
			<th class="outer" colspan="<{if $chess_rating_system != 'none'}>5<{else}>4<{/if}>">
				<{$smarty.const._MD_CHESS_LABEL_GAMES}>
				&nbsp;&nbsp;
				<{$form2.elements.gshow1.body}>
				&nbsp;&nbsp;
				<{if $chess_rating_system != 'none'}>
					<{$form2.elements.gshow2.body}>
					&nbsp;&nbsp;
				<{/if}>
				<{$form2.elements.cstart.body}>
				<{$form2.elements.cshow.body}>
				<{$form2.elements.submit.body}>
			</th>
		</tr>

<{if !empty($chess_games)}>

		<tr class="head">
			<td class="head" colspan="2"><{$smarty.const._MD_CHESS_LABEL_GAME}></td>
			<td class="head"><{$smarty.const._MD_CHESS_LAST_ACTIVITY}></td>
			<td class="head"><{$smarty.const._MD_CHESS_STATUS}></td>
			<{if $chess_rating_system != 'none'}>
				<td class="head"><{$smarty.const._MD_CHESS_RATED_GAME}></td>
			<{/if}>
		</tr>

		<{foreach from=$chess_games item=game}>
			<{cycle values="odd,even" assign=class}>
			<tr class="<{$class}>">
				<td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/game.php?game_id=<{$game.game_id}>"><{$game.game_id}></a></td>
				<td class="<{$class}>"><{$game.username_white}> <{$smarty.const._MD_CHESS_LABEL_VS}> <{$game.username_black}></td>
				<td class="<{$class}>"><{$chess_date_format|date:$game.last_activity}></td>
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
				<{if $chess_rating_system != 'none'}>
					<td class="<{$class}>"><{if $game.is_rated}><{$smarty.const._YES}><{else}><{$smarty.const._NO}><{/if}></td>
				<{/if}>
			</tr>
		<{/foreach}>

<{else}>

		<tr class="odd">
			<td class="odd" colspan="<{if $chess_rating_system != 'none'}>5<{else}>4<{/if}>"><{$smarty.const._MD_CHESS_LABEL_NO_GAMES}></td>
		</tr>

<{/if}>

</table>

</form>

<div class="head" align="center"><{$chess_games_pagenav}>&nbsp;</div>

<{* Notifications *}>
<{include file='db:system_notification_select.tpl'}>
