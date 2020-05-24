<{if !empty($chess_msg)}>
    <div class='<{$chess_msg_class}>'><{$chess_msg}></div>
    <{/if}>

<table class="outer">

    <th class="outer" colspan="3"><{$smarty.const._MD_CHESS_PLAYER_RATINGS}></th>

    <{if !empty($chess_players)}>

    <tr class="head">
        <td class="head"><{$smarty.const._MD_CHESS_PLAYER}></td>
        <td class="head"><{$smarty.const._MD_CHESS_RATING}></td>
        <td class="head"><{$smarty.const._MD_CHESS_GAMES_PLAYED}></td>
    </tr>

    <{assign var='chess_provisional_ratings_present' value=false}>

    <{foreach from=$chess_players item=player}>

    <{if $player.games_played < $chess_provisional_games}>
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
        <td class="odd" colspan="3">
            <{$smarty.const._MD_CHESS_NO_RATING_INFO}>
        </td>
    </tr>

    <{/if}>

</table>

<div class="head" align="center"><{$chess_players_pagenav}>&nbsp;</div>

<{if $chess_provisional_ratings_present}>
<br><br>
    <b>*</b><{$chess_provisional_games|string_format:$smarty.const._MD_CHESS_PROVISIONAL}>
    <{/if}>


<{* form for arbiter to recalculate ratings *}>

<{if isset($form1)}>

<br><br>

<form name='<{$form1.name}>' id='<{$form1.name}>' action='<{$form1.action}>' method='<{$form1.method}>' <{$form1.extra}>>

    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$form1.title}></th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'><{$form1.elements.submit_recalc_ratings.body}></td>
            <td class='head'><{$form1.elements.confirm_recalc_ratings.body}></td>
        </tr>

    </table>

    <{$chess_xoops_request_token}>

    </form>

    <{/if}>
