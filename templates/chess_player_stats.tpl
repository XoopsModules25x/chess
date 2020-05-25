<{* form for selecting player and display-option *}>

<form name='<{$form1.name}>' id='<{$form1.name}>' action='<{$form1.action}>' method='<{$form1.method}>' <{$form1.extra}>>

<table width='100%' class='outer' cellspacing='1'>
    <tr>
        <th colspan='2'><{$form1.title}></th>
    </tr>
    <tr valign='top' align='left'>
        <td class='head'>
            <{$smarty.const._MD_CHESS_USERNAME}>:
            &nbsp;
            <{$form1.elements.player_uname.body}>
            &nbsp;&nbsp;
            <{$form1.elements.show_option.body}>
            &nbsp;&nbsp;
            <{$form1.elements.submit_select_player.body}>
        </td>
    </tr>
</table>

</form>

<{* player's challenges *}>

<br>

<table class="outer">
    <tr class="outer">
        <th class="outer" colspan="<{if $chess_rating_system != 'none'}>5<{else}>4<{/if}>"><{$chess_player.uname|string_format:$smarty.const._MD_CHESS_CHALLENGES_FOR}></th>
    </tr>

    <{if !empty($chess_player.challenges)}>

    <tr class="head">
        <td class="head"><{$smarty.const._MD_CHESS_LABEL_TYPE}></td>
        <td class="head"><{$smarty.const._MD_CHESS_LABEL_CHALLENGER}></td>
        <td class="head"><{$smarty.const._MD_CHESS_LABEL_CREATED}></td>
        <td class="head"><{$smarty.const._MD_CHESS_LABEL_COLOR_OPTION}></td>
        <{if $chess_rating_system != 'none'}>
        <td class="head"><{$smarty.const._MD_CHESS_RATED_GAME}></td>
        <{/if}>
    </tr>

    <{foreach from=$chess_player.challenges item=challenge}>
    <{cycle values="odd,even" assign=class}>
    <{if $challenge.game_type eq $smarty.const._CHESS_GAMETYPE_OPEN}>
    <{assign var=gametype value=$smarty.const._MD_CHESS_LABEL_GAMETYPE_OPEN}>
    <{elseif $challenge.game_type eq $smarty.const._CHESS_GAMETYPE_USER}>
    <{assign var=gametype value=$smarty.const._MD_CHESS_LABEL_GAMETYPE_USER|cat:': '|cat:$challenge.player2_uname}>
    <{else}>
    <{assign var=gametype value='<div class="errorMsg">'|cat:$smarty.const._MD_CHESS_LABEL_ERROR|cat:'</div>'}>
    <{/if}>
    <tr class="<{$class}>">
        <td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/create.php?challenge_id=<{$challenge.challenge_id}>"><{$gametype}></a></td>
        <td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/player_stats.php?player_uid=<{$challenge.player1_uid}>"><{$challenge.player1_uname}></a></td>
        <td class="<{$class}>"><{$smarty.const._MEDIUMDATESTRING|date:$challenge.create_date}></td>
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

<div class="head" align="center"><{$chess_challenges_pagenav}>&nbsp;</div>

<{* player's games *}>

<br>

<table class="outer">

    <th class="outer" colspan="<{if $chess_rating_system != 'none'}>5<{else}>4<{/if}>"><{$chess_player.uname|string_format:$smarty.const._MD_CHESS_GAMES_FOR}></th>

    <{if !empty($chess_player.games)}>

    <tr class="head">
        <td class="head" colspan="2"><{$smarty.const._MD_CHESS_LABEL_GAME}></td>
        <td class="head"><{$smarty.const._MD_CHESS_LAST_ACTIVITY}></td>
        <td class="head"><{$smarty.const._MD_CHESS_STATUS}></td>
        <{if $chess_rating_system != 'none'}>
        <td class="head"><{$smarty.const._MD_CHESS_RATED_GAME}></td>
        <{/if}>
    </tr>

    <{foreach from=$chess_player.games item=game}>

    <{cycle values="odd,even" assign=class}>
    <tr class="<{$class}>">
        <td class="<{$class}>"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/game.php?game_id=<{$game.game_id}>"><{$game.game_id}></a></td>
        <td class="<{$class}>">
            <a href="<{$smarty.const.XOOPS_URL}>/modules/chess/player_stats.php?player_uid=<{$game.white_uid}><{$chess_show_option_urlparam}>"><{$game.white_uname}></a>
            <{$smarty.const._MD_CHESS_LABEL_VS}>
            <a href="<{$smarty.const.XOOPS_URL}>/modules/chess/player_stats.php?player_uid=<{$game.black_uid}><{$chess_show_option_urlparam}>"><{$game.black_uname}></a>
        </td>
        <td class="<{$class}>"><{$smarty.const._MEDIUMDATESTRING|date:$game.last_activity}></td>

        <{if $game.pgn_result == '1/2-1/2'}>
        <td class="<{$class}>"><b><{$smarty.const._MD_CHESS_DRAWN}></b></td>
        <{elseif ($game.pgn_result=='1-0' && $game.white_uid==$chess_player.uid) || ($game.pgn_result=='0-1' && $game.black_uid==$chess_player.uid)}>
        <td class="<{$class}>"><{$chess_player.uname}> <b><{$smarty.const._MD_CHESS_WON}></b></td>
        <{elseif ($game.pgn_result=='0-1' && $game.white_uid==$chess_player.uid) || ($game.pgn_result=='1-0' && $game.black_uid==$chess_player.uid)}>
        <td class="<{$class}>"><{$chess_player.uname}> <b><{$smarty.const._MD_CHESS_LOST}></b></td>
        <{elseif $game.fen_active_color == 'w'}>
        <td class="<{$class}>"><{$game.white_uname}> <{$smarty.const._MD_CHESS_LABEL_TO_MOVE}></td>
        <{else}>
        <td class="<{$class}>"><{$game.black_uname}> <{$smarty.const._MD_CHESS_LABEL_TO_MOVE}></td>
        <{/if}>

        <{if $chess_rating_system != 'none'}>
        <td class="<{$class}>"><{if $game.is_rated}><{$smarty.const._YES}><{else}><{$smarty.const._NO}><{/if}></td>
        <{/if}>
    </tr>
    <{/foreach}>

    <{else}>

    <tr class="odd">
        <td class="odd" colspan="3">
            <{$smarty.const._MD_CHESS_LABEL_NO_GAMES}>
        </td>
    </tr>

    <{/if}>

</table>

<div class="head" align="center"><{$chess_games_pagenav}>&nbsp;</div>

<{* player's stats *}>

<{* only display stats if rating feature enabled *}>
<{if $chess_rating_system != 'none'}>

<br>

    <table>

        <th class="outer" colspan="3"><{$chess_player.uname|string_format:$smarty.const._MD_CHESS_STATS_FOR}></th>

        <{* check that player's rating data is available *}>
        <{if isset($chess_player.rating)}>

        <{if $chess_player.games_played < $chess_provisional_games}>
        <{assign var='chess_provisional_rating_indicator' value='*'}>
        <{assign var='chess_ranking' value=$smarty.const._MD_CHESS_NA|cat:'*'}>
        <{else}>
        <{assign var='chess_provisional_rating_indicator' value=''}>
        <{assign var='chess_ranking' value=$chess_player.ranking}>
        <{/if}>

        <tr class="head">
            <td class="head"><{$smarty.const._MD_CHESS_RANKED}></td>
            <td class="odd" colspan='2'><{$chess_ranking}></td>
        </tr>
        <tr class="head">
            <td class="head"><{$smarty.const._MD_CHESS_RATING}></td>
            <td class="odd" colspan='2'><{$chess_player.rating}><{$chess_provisional_rating_indicator}></td>
        </tr>
        <tr class="head">
            <td class="head"><{$smarty.const._MD_CHESS_RATED_GAMES_PLAYED}></td>
            <td class="odd" colspan='2'><{$chess_player.games_played}></td>
        </tr>
        <tr class="head">
            <td class="head" width='33%'><{$smarty.const._MD_CHESS_WON|capitalize}>
            </th>
            <td class="head" width='34%'><{$smarty.const._MD_CHESS_LOST|capitalize}>
            </th>
            <td class="head" width='33%'><{$smarty.const._MD_CHESS_DRAWN|capitalize}>
            </th>
        </tr>
        <tr class="head" align='center'>
            <td class="odd"><{$chess_player.games_won}></td>
            <td class="odd"><{$chess_player.games_lost}></td>
            <td class="odd"><{$chess_player.games_drawn}></td>
        </tr>

        <{else}>

        <tr class="odd">
            <td class="odd" colspan="3"><{$smarty.const._MD_CHESS_NO_RATING_INFO}></td>
        </tr>

        <{/if}>

    </table>

    <{if isset($chess_player.rating) && $chess_player.games_played < $chess_provisional_games}>
<br><br>
    <b>*</b><{$chess_provisional_games|string_format:$smarty.const._MD_CHESS_PROVISIONAL}>
    <{/if}>

    <{/if}>


<{* link to player's profile *}>

<br>

<table>
    <tr class="head">
        <td class="head" align="center"><a href="<{$xoops_url}>/userinfo.php?uid=<{$chess_player.uid}>"><{$smarty.const._MD_CHESS_VIEW_PROFILE}></a></td>
    </tr>
</table>
