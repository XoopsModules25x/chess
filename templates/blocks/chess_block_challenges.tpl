<table class="outer">

<{if !empty($block.challenges)}>

		<tr class="head">
			<td class="head"><{$smarty.const._MB_CHESS_TYPE}></td>
			<td class="head"><{$smarty.const._MB_CHESS_CHALLENGER}></td>
			<td class="head"><{$smarty.const._MB_CHESS_CREATED}></td>
		</tr>

		<{foreach from=$block.challenges item=challenge}>
			<{cycle values="odd,even" assign=class}>
			<{if $challenge.game_type eq $smarty.const._CHESS_GAMETYPE_OPEN}>
				<{assign var=gametype value=$smarty.const._MB_CHESS_GAMETYPE_OPEN}>
			<{elseif $challenge.game_type eq $smarty.const._CHESS_GAMETYPE_USER}>
				<{assign var=gametype value=$smarty.const._MB_CHESS_GAMETYPE_USER|cat:': '|cat:$challenge.username_player2}>
			<{else}>
				<{assign var=gametype value='<div class="errorMsg">'|cat:$smarty.const._MB_CHESS_ERROR|cat:'</div>'}>
			<{/if}>
			<tr class="<{$class}>">
				<td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/create.php?challenge_id=<{$challenge.challenge_id}>"><{$gametype}></a></td>
				<td class="<{$class}>"><{$challenge.username_player1}></td>
				<td class="<{$class}>"><{$challenge.create_date|xoops_format_date:$block.date_format}></td>
			</tr>
		<{/foreach}>

<{else}>

		<tr class="odd">
			<td class="odd" colspan="4"><{$smarty.const._MB_CHESS_NO_CHALLENGES}></td>
		</tr>

<{/if}>

</table>
