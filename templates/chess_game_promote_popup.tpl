<{*
After this Smarty template is complied, it's used as the parameter in the Javascript method document.write(),
so be careful with quotes here.

Also, I couldn't get the <script> tag to work in this context, so I inlined the required Javascript in the OnClick attribute,
instead of using a function call.
*}>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$smarty.const._LANGCODE}>" lang="<{$smarty.const._LANGCODE}>">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<{$smarty.const._CHARSET}>">
    <meta http-equiv="content-language" content="<{$smarty.const._LANGCODE}>">
    <title>Pawn Promotion</title>
</head>

<body>

<table>

    <tr>
        <td style="text-align:center" colspan="<{$chess_pawn_promote_choices|@count}>">
            <strong><{$smarty.const._MD_CHESS_PROMOTE_TO|replace:' ':'&nbsp;'}>:</strong>
        </td>
    </tr>

    <tr>

        <{foreach from=$chess_pawn_promote_choices item="piece"}>

        <td>
            <a href="javascript:void(0)" onClick="javascript:window.opener.document.cmdform.chessmove.value += \'=<{$piece|upper}>\';window.close();">
                <img border="1" width="36" height="36" alt="<{$chess_pieces[$piece].alt}>" title="<{$chess_pieces[$piece].alt}>" src="assets/images/wcg/<{$chess_pieces[$piece].name}>.gif">
            </a>
        </td>

        <{/foreach}>

    </tr>

</table>

</body>
</html>
