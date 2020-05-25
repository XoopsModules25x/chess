<script type="text/javascript" language="javascript">

    <{if $chess_user_color}>

    function confirmAction() {
    <{* no action unless the confirm-checkbox is selected *}>
        if (!window.document.cmdform.confirm.checked) {
            return true;
        }

    <{* determine which radio button is selected *}>
        for (i = 0; i < window.document.cmdform.movetype.length; ++i) {
            if (window.document.cmdform.movetype[i].checked) {
                value = window.document.cmdform.movetype[i].value;
                break;
            }
        }

    <{* determine confirm-text to display based on which radio button is selected *}>
        switch (value) {
            case '<{$smarty.const._CHESS_MOVETYPE_NORMAL}>':
                text = window.document.cmdform.chessmove.value + '?';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_CLAIM_DRAW_50}>':
                if (window.document.cmdform.chessmove.value) {
                    extra_text = ' <{$smarty.const._MD_CHESS_AFTER_MOVE}> ' + window.document.cmdform.chessmove.value;
                } else {
                    extra_text = '';
                }
                text = '<{$smarty.const._MD_CHESS_CLAIM_DRAW_50}>' + extra_text + '?';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_CLAIM_DRAW_3}>':
                if (window.document.cmdform.chessmove.value) {
                    extra_text = ' <{$smarty.const._MD_CHESS_AFTER_MOVE}> ' + window.document.cmdform.chessmove.value;
                } else {
                    extra_text = '';
                }
                text = '<{$smarty.const._MD_CHESS_CLAIM_DRAW_3}>' + extra_text + '?';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_RESIGN}>':
                text = '<{$smarty.const._MD_CHESS_RESIGN}>' + '?';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_OFFER_DRAW}>':
                text = '<{$smarty.const._MD_CHESS_OFFER_DRAW}>' + '?';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_ACCEPT_DRAW}>':
                text = '<{$smarty.const._MD_CHESS_ACCEPT_DRAW}>' + '?';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_REJECT_DRAW}>':
                text = '<{$smarty.const._MD_CHESS_REJECT_DRAW}>' + '?';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_RESTART}>':
                text = '<{$smarty.const._MD_CHESS_RESTART}>' + '?';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_DELETE}>':
                text = '<{$smarty.const._MD_CHESS_DELETE}>' + '?  ' + '<{$smarty.const._MD_CHESS_DELETE_WARNING}>';
                ask = true;
                break;
            case '<{$smarty.const._CHESS_MOVETYPE_WANT_ARBITRATION}>':
                text = '<{$smarty.const._MD_CHESS_WANT_ARBITRATION}>' + '?';
                ask = true;
                break;
            default:
                text = '';
                ask = false;
                break;
        }

    <{* if an action requiring confirmation was selected, display the confirm-dialog *}>
        if (ask) {
            return window.confirm(text);
        } else {
            return true;
        }
    }

    <{/if}>

</script>

<{* selfplay - it's a self-play game *}>
<{if $chess_gamedata.white_uid eq $chess_gamedata.black_uid}>
    <{assign var=selfplay value=true}>
    <{else}>
    <{assign var=selfplay value=false}>
    <{/if}>

<{* can_move - the game isn't over or suspended, it's the current user's move, and he hasn't offered a draw that has been neither accepted nor rejected *}>
<{if $chess_gamedata.pgn_result eq '*' && not $chess_gamedata.suspended && $chess_user_color eq $chess_gamedata.fen_active_color && $chess_gamedata.offer_draw ne $chess_user_color}>
    <{assign var=can_move value=true}>
    <{else}>
    <{assign var=can_move value=false}>
    <{/if}>

<table>

    <tr>
        <td style="text-align:center">

            <table>

                <{* #*#TBD# - color of player names in th-tag not visible enough in some themes, e.g. default theme, since they're in a-tags. *}>
                <th style="text-align:center" colspan="2"><a href="<{$smarty.const.XOOPS_URL}>/modules/chess/player_stats.php?player_uid=<{$chess_gamedata.white_uid}>"><span style="font-size: larger; "><b><{$chess_white_user|replace:' ':'&nbsp;'}></b></span></a>&nbsp;<{$smarty.const._MD_CHESS_LABEL_VS}>&nbsp;<a
                            href="<{$smarty.const.XOOPS_URL}>/modules/chess/player_stats.php?player_uid=<{$chess_gamedata.black_uid}>"><span style="font-size: larger; "><b><{$chess_black_user|replace:' ':'&nbsp;'}></b></span></a></th>

                <{* Display first and last move dates if defined, otherwise display game creation date. *}>
                <{assign var=chess_date_format_nbsp value=$chess_date_format|replace:' ':'\&\n\b\s\p\;'}>
                <{if $chess_start_date && $chess_last_date}>
                <tr>
                    <td class="odd" style="text-align:left"><{$smarty.const._MD_CHESS_GAME_STARTED|replace:' ':'&nbsp;'}>:</td>
                    <td class="odd" style="text-align:right"><{$chess_date_format_nbsp|date:$chess_start_date}></td>
                </tr>
                <tr>
                    <td class="odd" style="text-align:left"><{$smarty.const._MD_CHESS_LABEL_LAST_MOVE|replace:' ':'&nbsp;'}>:</td>
                    <td class="odd" style="text-align:right"><{$chess_date_format_nbsp|date:$chess_last_date}></td>
                </tr>
                <{else}>
                <tr>
                    <td class="odd" style="text-align:left"><{$smarty.const._MD_CHESS_GAME_CREATED|replace:' ':'&nbsp;'}>:</td>
                    <td class="odd" style="text-align:right"><{$chess_date_format_nbsp|date:$chess_create_date}></td>
                </tr>
                <{/if}>

                <{* If rating feature enabled, indicate whether this game is rated. *}>
                <{if $chess_ratings_enabled}>
                <tr>
                    <td class="odd" style="text-align:left"><{$smarty.const._MD_CHESS_RATED_GAME|replace:' ':'&nbsp;'}>:</td>
                    <td class="odd" style="text-align:right"><{if $chess_gamedata.is_rated}><{$smarty.const._YES}><{else}><{$smarty.const._NO}><{/if}></td>
                </tr>
                <{/if}>

                <{* If game is suspended, indicate it. *}>
                <{if $chess_gamedata.suspended}>

                <tr>
                    <td class="head" style="text-align:center" colspan="2">
                        <{if $chess_gamedata.fen_active_color eq 'w'}>
                        <{$smarty.const._MD_CHESS_LABEL_WHITE}> (<{$chess_white_user|replace:' ':'&nbsp;'}>) <{$smarty.const._MD_CHESS_LABEL_TO_MOVE}>
                        <{else}>
                        <{$smarty.const._MD_CHESS_LABEL_BLACK}> (<{$chess_black_user|replace:' ':'&nbsp;'}>) <{$smarty.const._MD_CHESS_LABEL_TO_MOVE}>
                        <{/if}>
                    </td>
                </tr>
                <tr>
                    <td class="head" style="text-align:center" colspan="2">
                        <{$smarty.const._MD_CHESS_LABEL_GAME_SUSPENDED}>
                    </td>
                </tr>

                <{* If game is over, display result. *}>
                <{elseif $chess_gamedata.pgn_result ne '*'}>

                <tr>
                    <td class="head" style="text-align:center" colspan="2"><{$smarty.const._MD_CHESS_LABEL_GAME_OVER}>: <{$chess_gamedata.pgn_result}></td>
                </tr>

                <{* Display game result comment, if present. *}>
                <{if !empty($chess_result_comment)}>
                <tr>
                    <td class="head" style="text-align:center" colspan="2"><{$chess_result_comment}></td>
                </tr>
                <{/if}>

                <{* Otherwise game is in progress, so display move-form. *}>
                <{else}>

                <tr>
                    <td colspan="2"><{include file="db:chess_game_moveform.tpl"}></td>
                </tr>

                <{/if}>

            </table>

            <{if !empty($chess_movelist)}>

        <br>
            <table>
                <tr>
                    <td class="head" style="text-align:center" colspan="3"><{$smarty.const._MD_CHESS_MOVE_LIST}></td>
                </tr>
                <{foreach from=$chess_movelist item=move}>
                <{cycle values="odd,even" assign=class}>
                <tr>
                    <td class="<{$class}>" style="text-align:right"><{if $move[0]}><{$move[0]}><{else}>&nbsp;<{/if}>&nbsp;</td>
                    <{* move number  *}>
                    <td class="<{$class}>" style="text-align:left"> <{if $move[1]}><{$move[1]}><{else}>&nbsp;<{/if}></td>
                    <{* white's move *}>
                    <td class="<{$class}>" style="text-align:left"> <{if $move[2]}><{$move[2]}><{else}>&nbsp;<{/if}></td>
                    <{* black's move *}>
                </tr>
                <{/foreach}>
            </table>
            <{/if}>

            <br>

            <table>
                <tr>
                    <td class="head" style="text-align:center"><{$smarty.const._MD_CHESS_EXPORT_FORMATS}></td>
                </tr>
                <tr>
                    <td class="odd">
                        <b><{$smarty.const._MD_CHESS_PGN_FULL}> (<{$smarty.const._MD_CHESS_PGN_ABBREV}>)</b><br>
                        <{* textarea tag not part of a form, only used for display purposes, and to allow easy copying *}>
                        <textarea name="pgn_display" rows="3" cols="40"><{$chess_pgn_string}></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="odd">
                        <b><{$smarty.const._MD_CHESS_FEN_FULL}> (<{$smarty.const._MD_CHESS_FEN_ABBREV}>)</b><br>
                        <{* textarea tag not part of a form, only used for display purposes, and to allow easy copying *}>
                        <{strip}>
                        <textarea name="fen_display" rows="1" cols="40">
                    <{$chess_gamedata.fen_piece_placement}>&nbsp;
                    <{$chess_gamedata.fen_active_color}>&nbsp;
                    <{$chess_gamedata.fen_castling_availability}>&nbsp;
                    <{$chess_gamedata.fen_en_passant_target_square}>&nbsp;
                    <{$chess_gamedata.fen_halfmove_clock}>&nbsp;
                    <{$chess_gamedata.fen_fullmove_number}>
                </textarea>
                        <{/strip}>
                    </td>
                </tr>
            </table>

        </td>

        <td style="text-align:center">

            <{include file="db:chess_game_board.tpl"}>

            <{if $can_move}>

            <noscript>
                <br>

                <table>
                    <tr>
                        <td>
                            <div class="errorMsg"><{$smarty.const._MD_CHESS_NO_JAVASCRIPT}></div>
                        </td>
                    </tr>
                </table>
            </noscript>

            <{/if}>

            <{* display captured pieces *}>
            <{if !empty($chess_captured_pieces.white) || !empty($chess_captured_pieces.black)}>

        <br>

            <table border="0">
                <tr>
                    <td class="head" style="text-align:center">
                        <{$smarty.const._MD_CHESS_CAPTURED_PIECES}>
                    </td>
                </tr>
                <{foreach from=$chess_captured_pieces item=captured_pieces_color}>
                <tr>
                    <td class="odd" style="text-align:left">
                        <{foreach from=$captured_pieces_color item=piece}>
                    <img border="0" width="20" height="21" alt="<{$chess_pieces[$piece].alt}>" src="assets/images/wcg/s<{$chess_pieces[$piece].name}>.gif">
                        <{/foreach}>
                    </td>
                    <{if empty($captured_pieces_color)}>
                    <td class="odd">&nbsp;</td>
                    <{/if}>
                </tr>
                <{/foreach}>
            </table>

            <{/if}>

            <br>

            <{include file="db:chess_game_prefsform.tpl"}>

            <{if $chess_show_arbitration_controls}>

        <br>
            <{include file="db:chess_game_arbitrateform.tpl"}>

            <{/if}>

        </td>
    </tr>
</table>

<{* #*#DEBUG# *}>
<{***
<br>
Debug info:<br>
<{foreach from=$chess_gamedata key=key item=value}>
gamedata['<{$key}>']='<{$value}>'<br>
<{/foreach}>
***}>

<{* Comments *}>

<div style="text-align: center; padding: 3px; margin: 3px;">
    <{$commentsnav}>
    <{$lang_notice}>
</div>

<div style="margin: 3px; padding: 3px;">
    <!-- start comments loop -->
    <{if $comment_mode == "flat"}>
    <{include file="db:system_comments_flat.tpl"}>
    <{elseif $comment_mode == "thread"}>
    <{include file="db:system_comments_thread.tpl"}>
    <{elseif $comment_mode == "nest"}>
    <{include file="db:system_comments_nest.tpl"}>
    <{/if}>
    <!-- end comments loop -->
</div>

<{* Notifications *}>
<{include file='db:system_notification_select.tpl'}>

<{* preload images *}>

<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wking.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wqueen.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wrook.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wbishop.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wknight.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wpawn.gif">

<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bking.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bqueen.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/brook.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bbishop.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bknight.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bpawn.gif">

<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/w_square.jpg">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/b_square.jpg">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/empty.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/spacer.gif">

<{if $can_move}>
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wking_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wqueen_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wrook_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wbishop_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wknight_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/wpawn_h.gif">

<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bking_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bqueen_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/brook_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bbishop_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bknight_h.gif">
<img class="chessHiddenPic" height="1" width="1" alt="-" src="assets/images/wcg/bpawn_h.gif">
    <{/if}>
