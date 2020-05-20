<{if $block.rating_system != 'none'}>

	<table class="outer">

	<{if !empty($block.players)}>
	
		<tr class="head">
			<td class="head"><{$smarty.const._MB_CHESS_PLAYER}></td>
			<td class="head"><{$smarty.const._MB_CHESS_RATING}></td>
			<td class="head"><{$smarty.const._MB_CHESS_GAMES_PLAYED}></td>
		</tr>
	
		<{assign var=$chess_provisional_ratings_present value=false}>
	
		<{foreach from=$block.players item=player}>
	
			<{if $player.games_played < $block.provisional_games}>
				<{assign var='chess_provisional_ratings_present'  value=true}>
				<{assign var='chess_provisional_rating_indicator' value='*'}>
			<{else}>
				<{assign var='chess_provisional_rating_indicator' value=''}>
			<{/if}>
			
			<{cycle values="odd,even" assign=class}>
			<tr class="<{$class}>">
				<td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/player_stats.php?player_uid=<{$player.player_uid}>"><{$player.player_uname}></a></td>
				<td class="<{$class}>"><{$player.rating}><{$chess_provisional_rating_indicator}></td>
				<td class="<{$class}>"><{$player.games_played}></td>
			</tr>
		<{/foreach}>
	
	<{else}>
	
		<tr class="odd">
			<td class="odd" colspan="5">
				<{if $block.show_provisional_ratings}>
					<{$smarty.const._MB_CHESS_NO_RATED_GAMES}>
				<{else}>
					<{$smarty.const._MB_CHESS_NO_NONPROV_GAMES}>
				<{/if}>
			</td>
		</tr>
	
	<{/if}>
	
	</table>
	
	<{if $chess_provisional_ratings_present}>
		<br><br>
		<b>*</b><{$block.provisional_games|string_format:$smarty.const._MB_CHESS_PROVISIONAL}>
	<{/if}>

<{else}>

		<{$smarty.const._MB_CHESS_RATINGS_OFF}>

<{/if}>
