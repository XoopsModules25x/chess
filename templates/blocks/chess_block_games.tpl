<table class="outer">

    <{if !empty($block.games)}>

    <tr class="head">
        <td class="head"><{$smarty.const._MB_CHESS_GAME}></td>
        <td class="head"><{$smarty.const._MB_CHESS_DATE}></td>
        <td class="head"><{$smarty.const._MB_CHESS_STATUS}></td>
    </tr>

    <{foreach from=$block.games item=game}>
    <{cycle values="odd,even" assign=class}>
    <tr class="<{$class}>">
        <td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/game.php?game_id=<{$game.game_id}>"><{$game.username_white}> <{$smarty.const._MB_CHESS_VS}> <{$game.username_black}></a></td>
        <td class="<{$class}>"><{$block.date_format|date:$game.date}></td>
        <td class="<{$class}>">
            <{if $game.pgn_result eq '1/2-1/2'}>
            <{$smarty.const._MB_CHESS_DRAW}>
            <{elseif $game.pgn_result eq '1-0'}>
            <{$smarty.const._MB_CHESS_WHITE_WON}>
            <{elseif $game.pgn_result eq '0-1'}>
            <{$smarty.const._MB_CHESS_BLACK_WON}>
            <{elseif $game.pgn_result eq '*'}>
            <{if $game.fen_active_color eq 'w'}>
            <{$smarty.const._MB_CHESS_WHITE_TO_MOVE}>
            <{else}>
            <{$smarty.const._MB_CHESS_BLACK_TO_MOVE}>
            <{/if}>
            <{else}>
            <div class="errorMsg"><{$chess.const._MB_CHESS_LABEL_ERROR}></div>
            <{/if}>
        </td>
    </tr>
    <{/foreach}>

    <{else}>

    <tr class="odd">
        <td class="odd" colspan="5"><{$smarty.const._MB_CHESS_LABEL_NO_GAMES}></td>
    </tr>

    <{/if}>

</table>
